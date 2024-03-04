//
//  PaymentCheckoutViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 10/01/23.
//

import UIKit

class PaymentCheckoutViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var nametextField: UITextField!
    @IBOutlet weak var emailTextField: UITextField!
    @IBOutlet weak var phoneTextField: UITextField!
    @IBOutlet weak var stateTextField: UITextField!
    @IBOutlet weak var cityTextField: UITextField!
    @IBOutlet weak var addressTextField: UITextView!
    @IBOutlet weak var zipCodeTextField: UITextField!
    
    // MARK: Variable initializer--
    var cartData : CartModelData?
    lazy var paymentViewModel:PaymentCheckoutViewModel = {
        var paymentViewModel = PaymentCheckoutViewModel()
        return paymentViewModel
    }()
    var quantity = 0
    // MARK: View Life Cycle
    override func viewDidLoad() {
        super.viewDidLoad()
        addressTextField.delegate = self
        addressTextField.text = DefaultValue.address.rawValue
        addressTextField.textColor = UIColor.white
        phoneTextField.delegate = self
        zipCodeTextField.delegate = self
        // Do any additional setup after loading the view.
    }
    // MARK: Create function for store data into textfields--
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        self.nametextField.text = cartData?.data?.activeAddress?.fullName
        self.emailTextField.text = cartData?.data?.activeAddress?.email
        self.phoneTextField.text = cartData?.data?.activeAddress?.phoneNo
        phoneTextField.text = self.format(with: DefaultValue.numberFormat.rawValue, phone: phoneTextField.text ?? DefaultValue.emptyString.rawValue)
        self.stateTextField.text = cartData?.data?.activeAddress?.state
        self.cityTextField.text = cartData?.data?.activeAddress?.city
        self.addressTextField.text = cartData?.data?.activeAddress?.address
        self.zipCodeTextField.text = cartData?.data?.activeAddress?.zipcode
        
    }

    // MARK: BackButton action--
    ///create a function for navigate to previous screen
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Submit Button Action--
    ///Create a function for validation in all the required field
    @IBAction func submitButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else if cartData?.data?.cartDatas?.first?.ticket?.price ?? 0 < 1{
            orderApi()
        }else {
            let vc = self.storyboard?.instantiateViewController(withIdentifier: PaymentViewController.identifier) as! PaymentViewController
            let activeAddress = ActiveAddressDetails(id: cartData?.data?.activeAddress?.id,fullName: nametextField.text,phoneNo: phoneTextField.text, email: emailTextField.text, zipcode:zipCodeTextField.text, state: stateTextField.text, city: cityTextField.text, address: addressTextField.text)
            vc.activeAddressDetails = activeAddress
            //vc.activeAddressDetails =
            vc.cartData = self.cartData
            vc.quantity = quantity
            self.navigationController?.pushViewController(vc, animated: false)
        }
        }
        // MARK: - Call the order API--
        func orderApi(){
            paymentViewModel.callOrderApi(userID: (cartData?.data?.cartDatas?.first?.userID ?? 0), totalPrice: Int((cartData?.data?.cartDatas?.first?.ticket?.price ?? 0)) * (quantity), billingAddressId: cartData?.data?.activeAddress?.id, fullName: nametextField.text, phoneNumber: phoneTextField.text, email: emailTextField.text, state: stateTextField.text, city: cityTextField.text, zipcode: zipCodeTextField.text, address: addressTextField.text, stripeToken: DefaultValue.emptyString.rawValue, cartItems: cartData?.data?.cartDatas?.first?.id ?? 0) {[weak self] orderData, isSuccess in
                if isSuccess == true{
                    let refreshAlert = UIAlertController(title: Alert.projectName, message: orderData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                    refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                        self?.tabBarController?.selectedIndex = 0
                    }))
                    self?.present(refreshAlert, animated: true, completion: nil)
                }else{
                }
            }
        }
        // MARK: TextFields Validation--
        func validation() -> String?{
            guard !(String.getString(self.nametextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterFirstName}
            guard String.getString(self.nametextField.text).isName() else{return AppMessage.shared.PleaseEnterValidFirstName}
            guard !(String.getString(self.emailTextField.text).isEmpty) else{return AppMessage.shared.pleaseEnterEmailAddress}
            guard String.getString(self.emailTextField.text).isEmail() else{return AppMessage.shared.pleaseEnterValidEmailAddress}
            guard !(String.getString(self.phoneTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterPhone}
            guard String.getString(self.phoneTextField.text).isPhoneNumber() else{return AppMessage.shared.PleaseEnterValidPhone}
            guard !(String.getString(self.stateTextField.text).isEmpty) else{return AppMessage.shared.EnterState}
            guard !(String.getString(self.cityTextField.text).isEmpty) else{return AppMessage.shared.EnterCity}
            guard !(String.getString(self.zipCodeTextField.text).isEmpty) else{return AppMessage.shared.EnterZipcode}
            guard String.getString(self.zipCodeTextField.text).isZipCodeNumber() else{return AppMessage.shared.EnterValidZipcode}
            guard !(String.getString(self.addressTextField.text).isEmpty) else{return AppMessage.shared.EnterAddress}
            return nil
        }
    }
//}
// MARK: Create extension for Payment View Controller--
//Create extension for phone textfield--
extension PaymentCheckoutViewController{
    /// Set the Number Format in PhoneTextField
    /// - Parameters: (mask, phone)
    ///   - mask: String
    ///   - phone: String
    /// - Returns: String
    func format(with mask: String, phone: String) -> String {
        let numbers = phone.replacingOccurrences(of: DefaultValue.ranges.rawValue, with: DefaultValue.emptyString.rawValue, options: .regularExpression)
        var result = DefaultValue.emptyString.rawValue
        var index = numbers.startIndex
        for ch in mask where index < numbers.endIndex {
            if ch == "X" {
                result.append(numbers[index])
                index = numbers.index(after: index)
            } else {
                result.append(ch)
            }}
        return result
    }}
// MARK: Extension for Textview delegate--
extension PaymentCheckoutViewController: UITextViewDelegate{
    func textViewDidBeginEditing(_ textView: UITextView) {
        if textView.textColor == UIColor.lightGray {
            textView.text = nil
            textView.textColor = UIColor.black
        }
    }
}
// MARK: Extension for TextField delegate--
extension PaymentCheckoutViewController: UITextFieldDelegate{
    func textFieldDidChangeSelection(_ textField: UITextField) {
        phoneTextField.text = self.format(with: DefaultValue.numberFormat.rawValue, phone: phoneTextField.text ?? DefaultValue.emptyString.rawValue)
    }
    ///Create function for set the maximum character in textfield
    /// - Parameter textField: UITextField
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case zipCodeTextField:
            guard let textFieldText = zipCodeTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 6
        default:
            return true
        }
    }
}
