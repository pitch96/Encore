//
//  PromoterPaymentViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/04/23.
//

import UIKit
import Stripe

class PromoterPaymentViewController: UIViewController, STPPaymentCardTextFieldDelegate {
  // MARK: - IBOutlets
    @IBOutlet weak var amountTextField: UITextField!
    @IBOutlet weak var nameTextField: UITextField!
    @IBOutlet weak var cardNumbertextField: UITextField!
    @IBOutlet weak var expiryMonthTextField: UITextField!
    @IBOutlet weak var expiryYearTextField: UITextField!
    @IBOutlet weak var cvvTextField: UITextField!
    
    // MARK: - Variable initializer
    lazy var paymentViewModel:PaymentViewModel = {
        var paymentViewModel = PaymentViewModel()
        return paymentViewModel
    }()
    let eventLiveResponseModel:EventLivePaymentModel? = nil
    var eventID:Int?
    var Ammount :Int?
    var chargemodel: EventChargeModel?
    
    // MARK: - ViewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        cardNumbertextField.delegate = self
        expiryYearTextField.delegate = self
        expiryMonthTextField.delegate = self
        nameTextField.delegate = self
        cvvTextField.delegate = self
        amountTextField.text = "$\(Ammount ?? 0)"
        amountTextField.isUserInteractionEnabled = false
        // Do any additional setup after loading the view.
    }
    
    // MARK: - Back Button Action
    ///Create action for navigate to previous screen
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: - Submit Button Action
    ///Create action for navigate to previous screen
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func SubmitButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            createStripeToekn()
        }
    }
    // MARK: - TextFields Validation
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation() -> String?{
        guard !(String.getString(self.nameTextField.text).isEmpty) else{return AppMessage.shared.EnterCardHolderName}
        guard !(String.getString(self.cardNumbertextField.text).isEmpty) else{return AppMessage.shared.EnterCardNumber}
        guard !(String.getString(self.cardNumbertextField.text).count < 16)else{return AppMessage.shared.EnterValidCardNumber}
        guard !(String.getString(self.expiryMonthTextField.text).isEmpty) else{return AppMessage.shared.EnterCardExpiryMonth}
        let a = (self.expiryMonthTextField.text ?? DefaultValue.emptyString.rawValue)
        if (a == "01") || (a == "02") || (a == "03") || (a == "04") || (a == "05") || (a == "06") || (a == "07") || (a == "08") || (a == "09") || (a == "10") || (a == "11") || (a == "12"){
        }else{
            return AppMessage.shared.EnterValidExpiryMonth
        }
        guard !(String.getString(self.expiryYearTextField.text).isEmpty) else{return AppMessage.shared.EnterCardExpiryYear}
        let b = (self.expiryYearTextField.text ?? DefaultValue.emptyString.rawValue)
        if (b == "2023") || (b == "2024") || (b == "2025") || (b == "2026") || (b == "2027") || (b == "2028") || (b == "2029") || (b == "2030") || (b == "2031") || (b == "2032") || (b == "2033") || (b == "2034") || (b == "2035") || (b == "2036") || (b == "2037") || (b == "2038") || (b == "2039") || (b == "2040"){
        }else{
            return AppMessage.shared.EnterValidExpiryYear
        }
        guard !(String.getString(self.cvvTextField.text).isEmpty) else{return AppMessage.shared.EnterCardCvv}
        return nil
    }
    // MARK: - Create a function for token
    ///to check the card number, month and year in stripe payment method
    private func createStripeToekn(){
        let cardParams = STPCardParams()
        cardParams.number = cardNumbertextField.text ?? DefaultValue.emptyString.rawValue
        cardParams.expMonth = UInt(expiryMonthTextField.text ?? "0") ?? 0
        cardParams.expYear = UInt(expiryYearTextField.text ?? "0") ?? 0
        cardParams.cvc = cvvTextField.text ?? DefaultValue.emptyString.rawValue
        STPAPIClient.shared.createToken(withCard: cardParams) { (token: STPToken?, error: Error?) in
            guard let token = token, error == nil else {
                // Present error to user...
                return
            }
            //Call place order API Here.
            self.callPayAmmoutAPI(stripToken: token.tokenId)
        }
    }
    // MARK: - Create function for Call Payment API
    private func callPayAmmoutAPI(stripToken:String) {
        guard let userId = UserDefaults.standard.value(forKey: DefaultValue.UserID.rawValue) as? Int else {return}
        //UserDefaults.standard.setValue(model.data?.id ?? 0, forKey: DefaultValue.UserID.rawValue)
        paymentViewModel.callPromoterPaymentApi(userID: userId , amount: Ammount ?? 0, eventID: eventID ?? 0, Striptoken: stripToken) {[weak self] data, isSuccess in
            if isSuccess == true{
                self?.refreshAlert(title: Alert.projectName, message:  data?.message ?? DefaultValue.errorMsg.rawValue)
            }else{
                self?.refreshAlert(title: Alert.projectName, message:  data?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
        
    }
}
// MARK: - Create Extention for textField delegate
extension PromoterPaymentViewController: UITextFieldDelegate{
    ///Create function for set the maximum character in textfield
    /// - Parameter textField: UITextField
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case cardNumbertextField:
            guard let textFieldText = cardNumbertextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 16
        case expiryYearTextField:
            guard let textFieldText = expiryYearTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 4
        case expiryMonthTextField:
            guard let textFieldText = expiryMonthTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 2
            
        case cvvTextField:
            guard let textFieldText = cvvTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 3
            
        case nameTextField:
            guard let textFieldText = nameTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 30
        default:
            return true
            }}}
