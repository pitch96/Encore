//
//  PaymentViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 11/01/23.
//

import UIKit
import Stripe

class PaymentViewController: UIViewController ,STPPaymentCardTextFieldDelegate {
    // MARK: IBOutlets--
    @IBOutlet weak var holderNameTextField: UITextField!
    @IBOutlet weak var cardNumbertextField: UITextField!
    @IBOutlet weak var expiryMonthTextField: UITextField!
    @IBOutlet weak var expiryYearTextField: UITextField!
    @IBOutlet weak var cvvTextField: UITextField!
    @IBOutlet weak var SubmitButton: UIButton!
    
    
    // MARK: Variable Initializer--
    var cartData : CartModelData?
    var activeAddressDetails: ActiveAddressDetails?
    lazy var cartViewModel:CartViewModel = {
        var cartViewModel = CartViewModel()
        return cartViewModel
    }()
    let datePicker = UIDatePicker()
    var quantity = 0
    // MARK: View Life Cycle --
    override func viewDidLoad() {
        super.viewDidLoad()
        cardNumbertextField.delegate = self
        expiryYearTextField.delegate = self
        expiryMonthTextField.delegate = self
        holderNameTextField.delegate = self
        cvvTextField.delegate = self
        self.title = DefaultValue.Standard.rawValue
       // openDatePicker(textField: expiryYearTextField)
    }
    // MARK: Navigate To Payment Checkout View Controller--
    /// Create Function For Navigate to Payment Checkout View Controller from SignUp
    /// - Parameter sender : UIButton
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    // MARK: Submit Button Action--
    /// Create Action for calling stripe token functionality
    /// - Parameter sender : UIButton
    @IBAction func submitButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            SubmitButton.isUserInteractionEnabled = false
            createStripeToekn()
        }
    }
    // MARK: TextFields Validation
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation() -> String?{
        guard !(String.getString(self.holderNameTextField.text).isEmpty) else{return AppMessage.shared.EnterCardHolderName}
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
    // MARK: Create a function for token--
    ///to check the card number, month and year in stripe payment method
    private func createStripeToekn(){
        
        let cardParams = STPCardParams()
        cardParams.number = cardNumbertextField.text ?? DefaultValue.emptyString.rawValue
        cardParams.expMonth = UInt(expiryMonthTextField.text ?? "0") ?? 0
        cardParams.expYear = UInt(expiryYearTextField.text ?? "0") ?? 0
        cardParams.cvc = cvvTextField.text ?? DefaultValue.emptyString.rawValue
        STPAPIClient.shared.createToken(withCard: cardParams) { (token: STPToken?, error: Error?) in
            self.SubmitButton.isUserInteractionEnabled = true
            guard let token = token, error == nil else {
                // Present error to user...
                return
            }
            //Call place order API Here.
            self.callPlaceOrderAPI(stripToken: token.tokenId)
        }
    }
    // MARK: Create a function for Calling Place Order Api--
    private func callPlaceOrderAPI(stripToken:String){
        cartViewModel.callPlacedOrderApi(userID: (cartData?.data?.cartDatas?.first?.userID ?? 0), totalPrice: Int((cartData?.data?.cartDatas?.first?.ticket?.price ?? 0)) * (quantity), billingAddressId: activeAddressDetails?.id, fullName: activeAddressDetails?.fullName, phoneNumber: activeAddressDetails?.phoneNo, email: activeAddressDetails?.email, state: activeAddressDetails?.state, city: activeAddressDetails?.city, zipcode: activeAddressDetails?.zipcode, address: activeAddressDetails?.address, stripeToken: stripToken , cartItems: cartData?.data?.cartDatas?.first?.id ?? 0 ) { [weak self] placaOrderData, isSuccess in
                if isSuccess{
                    let refreshAlert = UIAlertController(title: Alert.projectName, message: placaOrderData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                    refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                        for controller in (self?.navigationController!.viewControllers)! as Array {
                            if controller.isKind(of: CartViewController.self) {
                                self?.navigationController!.popToViewController(controller, animated: true)
                                break
                            }
                        }
                        self?.tabBarController?.selectedIndex = 2
                    }))
                    self?.present(refreshAlert, animated: true, completion: nil)
                    
                }else{
                    self?.showSimpleAlert(message: placaOrderData?.message ?? DefaultValue.errorMsg.rawValue)
                }}}
}
// MARK: Create Extention for textField delegate--
/// set the maximum limit in textfield
extension PaymentViewController: UITextFieldDelegate{
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
            
        case holderNameTextField:
            guard let textFieldText = holderNameTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 30
        default:
            return true
            }
        
    }
    
}
