//
//  SignUpVc.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 18/11/22.
//

import UIKit
import IQKeyboardManagerSwift

class SignUpViewController: UIViewController {
    //UserInterface
    // MARK: @IBOutlets--
    @IBOutlet weak var clientButton: UIButton!
    @IBOutlet weak var userButton: UIButton!
    @IBOutlet weak var backButton: UIButton!
    @IBOutlet weak var signUpButton: UIButton!
    @IBOutlet weak var viewConfirmPassword: UIView!
    @IBOutlet weak var viewPassword: UIView!
    @IBOutlet weak var viewCompanyName: UIView!
    @IBOutlet weak var viewPhoneNumber: UIView!
    @IBOutlet weak var viewEmail: UIView!
    @IBOutlet weak var viewLastName: UIView!
    @IBOutlet weak var viewFirstName: UIView!
    @IBOutlet weak var confirmPasswordTextField: UITextField!
    @IBOutlet weak var passwordTextField: UITextField!
    @IBOutlet weak var companyNameTextField: UITextField!
    @IBOutlet weak var phoneNumberTextField: UITextField!
    @IBOutlet weak var emailTextField: UITextField!
    @IBOutlet weak var lastNameTextField: UITextField!
    @IBOutlet weak var firstNameTextField: UITextField!
    
    // MARK: Variable Initialization--
    var userT = DefaultValue.user.rawValue
    var buttonArray = [UIButton]()
    var userType = 2
    lazy var signUpViewModel:UserSignUpViewModel = {
        var signUpViewModel = UserSignUpViewModel()
        return signUpViewModel
    }()
    var modelObject : UserSignUpModel?
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        
        firstNameTextField.delegate = self
        companyNameTextField.delegate = self
        lastNameTextField.delegate = self
        //set the user button first time
        self.userButton.isSelected = true
        self.phoneNumberTextField.delegate = self
        //set corner radius to button
        self.signUpButton.layer.cornerRadius = 10
        self.firstNameTextField.placeholderCostomization(placeHolderText: AppMessage.shared.FirstName)
        self.lastNameTextField.placeholderCostomization(placeHolderText: AppMessage.shared.LastName)
        self.emailTextField.placeholderCostomization(placeHolderText: AppMessage.shared.Email)
        self.phoneNumberTextField.placeholderCostomization(placeHolderText: AppMessage.shared.PhoneNumber)
        self.companyNameTextField.placeholderCostomization(placeHolderText: AppMessage.shared.Company)
        self.passwordTextField.placeholderCostomization(placeHolderText: AppMessage.shared.Password)
        self.confirmPasswordTextField.placeholderCostomization(placeHolderText: AppMessage.shared.ConfirmPassword)
    }    
    // MARK: Select User Button Action
    /// Create Function For select the user and promoter
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func selectedUserButtonAction(_ sender: UIButton) {
        buttonArray = [userButton,clientButton]
        switch buttonArray[sender.tag] {
        case userButton:
            self.userT = DefaultValue.user.rawValue
            removeTextval()
            debugPrint(self.userT)
        case clientButton:
            self.userT = DefaultValue.promoter.rawValue
            debugPrint(self.userT)
            removeTextval()
        default:
            break
        }
        buttonArray.forEach({
            $0.isSelected = false
        })
        sender.isSelected = true
    }
    // MARK: Change status bar color
    ///change the status bar Color in lightMode
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Eye Button Functionality
    ////function for secure entry textfield in password field
    @IBAction func passwordEyeButtonAction(_ sender: UIButton) {
        sender.isSelected = !sender.isSelected
        if sender.isSelected{
            passwordTextField.isSecureTextEntry = false
        }else{
            passwordTextField.isSecureTextEntry = true
        }
    }
    // MARK: Eye Button Functionality
    ////function for secure entry textfield in confirm password field
    @IBAction func confirmPasswordEyeButtonAction(_ sender: UIButton) {
        sender.isSelected = !sender.isSelected
        if sender.isSelected{
            confirmPasswordTextField.isSecureTextEntry = false
        }else{
            confirmPasswordTextField.isSecureTextEntry = true
        }
    }
    func removeTextval(){
        self.firstNameTextField.text = DefaultValue.emptyString.rawValue
        self.lastNameTextField.text = DefaultValue.emptyString.rawValue
        self.emailTextField.text = DefaultValue.emptyString.rawValue
        self.phoneNumberTextField.text = DefaultValue.emptyString.rawValue
        self.companyNameTextField.text = DefaultValue.emptyString.rawValue
        self.passwordTextField.text = DefaultValue.emptyString.rawValue
        self.confirmPasswordTextField.text = DefaultValue.emptyString.rawValue
        self.firstNameTextField.becomeFirstResponder()
    }
    // MARK: TextFields Validation
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation() -> String?{
        guard !(String.getString(self.firstNameTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterFirstName}
        guard String.getString(self.firstNameTextField.text).isName() else{return AppMessage.shared.PleaseEnterValidFirstName}
        guard !(String.getString(self.lastNameTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterLastName}
        guard String.getString(self.lastNameTextField.text).isName() else{return AppMessage.shared.PleaseEnterValidLastName}
        guard !(String.getString(self.emailTextField.text).isEmpty) else{return AppMessage.shared.pleaseEnterEmailAddress}
        guard String.getString(self.emailTextField.text).isEmail() else{return AppMessage.shared.pleaseEnterValidEmailAddress}
        guard !(String.getString(self.phoneNumberTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterPhone}
        guard String.getString(self.phoneNumberTextField.text).isPhoneNumber() else{return AppMessage.shared.PleaseEnterValidPhone}
        
        guard !(String.getString(self.companyNameTextField.text).isEmpty) else{return AppMessage.shared.PleaeEnterCompanyName}
        guard (String.getString(self.companyNameTextField.text)).isName() else{return AppMessage.shared.PleaseEnterValidCompanyName}
        
        guard !(String.getString(self.passwordTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterPassword}
        guard String.getString(self.passwordTextField.text).isValidPassword() else{return AppMessage.shared.PleaseEnterValidPassword}
        guard !(String.getString(self.confirmPasswordTextField.text).isEmpty) else{return AppMessage.shared.PleaseEnterConfirmPassword}
        guard self.confirmPasswordTextField.text == self.passwordTextField.text else{return AppMessage.shared.PasswordAndConfirmPassword}
        guard String.getString(self.confirmPasswordTextField.text).isPasswordValidate() else{return AppMessage.shared.MismatchPassword}
        return nil
    }
    // MARK: Register APi Call
    /// Create Function For Calling Login Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func signUpButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            callSignUpApi()
        }
    }
    // MARK: function for calling signUp APi--
    func callSignUpApi(){
        signUpViewModel.callSignUpApi(fName: firstNameTextField.text ?? DefaultValue.emptyString.rawValue, lName: lastNameTextField.text ?? DefaultValue.emptyString.rawValue, email: emailTextField.text ?? DefaultValue.emptyString.rawValue, phoneNum: phoneNumberTextField.text ?? DefaultValue.emptyString.rawValue, companyName: companyNameTextField.text ?? DefaultValue.emptyString.rawValue, pass: passwordTextField.text ?? DefaultValue.emptyString.rawValue, confirmPass: confirmPasswordTextField.text ?? DefaultValue.emptyString.rawValue, userType: self.userT) { [unowned self] UserDetailsSignUpData, isSuccess in
            if isSuccess{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: UserDetailsSignUpData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self.navigationController?.popViewController(animated: true)
                }))
                present(refreshAlert, animated: true, completion: nil)
            }else{
                self.showSimpleAlert(message: UserDetailsSignUpData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Navigate To Login Controller
    /// Create Function For Navigate to Login View Controller from SignUp
    /// - Parameter sender : UIButton
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
}
// MARK: Extension SignUpViewController
extension SignUpViewController{
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
// MARK: Extension for set the TextField Delgate
extension SignUpViewController: UITextFieldDelegate{
    ///Create function for set the number format in phone number textfield
    /// - Parameter textField: UITextField
    func textFieldDidChangeSelection(_ textField: UITextField) {
        phoneNumberTextField.text = self.format(with: DefaultValue.numberFormat.rawValue, phone: phoneNumberTextField.text ?? DefaultValue.emptyString.rawValue)
    }
    ///Create function for set the maximum character in textfield
    /// - Parameter textField: UITextField
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case firstNameTextField:
            guard let textFieldText = firstNameTextField.text,
                let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                    return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 25
        case lastNameTextField:
            guard let textFieldText = lastNameTextField.text,
                let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                    return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 25
        case companyNameTextField:
            guard let textFieldText = companyNameTextField.text,
                let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                    return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 70
        default:
            return true
        }
        
    }
}
