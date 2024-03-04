//
//  ContactUsViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 05/01/23.
//

import UIKit

class ContactUsViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var nameTextField: UITextField!
    @IBOutlet weak var emailTextField: UITextField!
    @IBOutlet weak var phoneTextField: UITextField!
    @IBOutlet weak var descriptionTextView: UITextView!
    // MARK: Variable Initialization
    lazy var contactUsViewModel:ContactUsViewModel = {
        var contactUsViewModel = ContactUsViewModel()
        return contactUsViewModel
    }()
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        descriptionTextView.delegate = self
        descriptionTextView.text = DefaultValue.query.rawValue
        descriptionTextView.textColor = UIColor.lightGray
        phoneTextField.delegate = self
        nameTextField.delegate = self
    
    }
    // MARK: Back Button Action
    /// Create Function For navigate to previous controller
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    
    // MARK: ContactUs APi Call
    /// Create Function For Calling ContactUs Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func contactUsButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            contactUsViewModel.callContactUsApi(name: nameTextField.text ?? DefaultValue.emptyString.rawValue, email: emailTextField.text ?? DefaultValue.emptyString.rawValue, phoneNum: phoneTextField.text ?? DefaultValue.emptyString.rawValue, query: descriptionTextView.text ?? DefaultValue.emptyString.rawValue) { ContactusData, isSuccess in
                if isSuccess == true{
                    let refreshAlert = UIAlertController(title: Alert.projectName, message: ContactusData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                    refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                        self.navigationController?.popViewController(animated: true)
                    }))
                    self.present(refreshAlert, animated: true, completion: nil)
                }else{
                    self.showSimpleAlert(message: ContactusData?.message ?? DefaultValue.errorMsg.rawValue)
                }
            }}
        }
    
    // MARK: TextFields Validation
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation() -> String?{
        guard !(String.getString(self.nameTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterFirstName}
        guard String.getString(self.nameTextField.text).isName() else{return AppMessage.shared.PleaseEnterValidFirstName}
        guard !(String.getString(self.emailTextField.text).isEmpty) else{return AppMessage.shared.pleaseEnterEmailAddress}
        guard String.getString(self.emailTextField.text).isEmail() else{return AppMessage.shared.pleaseEnterValidEmailAddress}
        guard !(String.getString(self.phoneTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterPhone}
        guard String.getString(self.phoneTextField.text).isPhoneNumber() else{return AppMessage.shared.PleaseEnterValidPhone}
        guard !(String.getString(self.descriptionTextView.text).isEmpty) else{return AppMessage.shared.EventDescription}
        //guard String.getString(self.descriptionTextView.text).isName() else{return AppMessage.shared.EventDescription}
        return nil
    }
}
// MARK: Extension ContactUsViewController
extension ContactUsViewController{
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
// MARK: Extension ContactUsViewController
///Create function for set the number format in phone number textfield
/// - Parameter textField: UITextField
extension ContactUsViewController: UITextFieldDelegate{
    func textFieldDidChangeSelection(_ textField: UITextField) {
        phoneTextField.text = self.format(with: DefaultValue.numberFormat.rawValue, phone: phoneTextField.text ?? DefaultValue.emptyString.rawValue)
    }
    ///Create function for set the maximum character in textfield
    /// - Parameter textField: UITextField
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case nameTextField:
            guard let textFieldText = nameTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 35
        default:
            return true
        }
    }
}
///Create function for set the textView placeholder in TextView
/// - Parameter textField: UITextField
extension ContactUsViewController: UITextViewDelegate{
    func textViewDidBeginEditing(_ textView: UITextView) {
        if textView.textColor == UIColor.lightGray {
            textView.text = nil
            textView.textColor = UIColor.white
        }
    }
}
