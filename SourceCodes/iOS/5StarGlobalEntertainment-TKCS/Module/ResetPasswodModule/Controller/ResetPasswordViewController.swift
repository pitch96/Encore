//
//  ResetPasswordViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import UIKit
class ResetPasswordViewController: UIViewController{
    // MARK: IBOutlet--
    @IBOutlet weak var confirmPasswordText: UITextField!
    @IBOutlet weak var newPasswordText: UITextField!
    @IBOutlet weak var otpText: UITextField!
    // MARK: Variable Initialization--
    var email:String?
    let ResetPasswordViewModels = ResetPasswordViewModel()
    var modelObject : ResetPasswordModel?
    
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        otpText.delegate = self
        self.otpText.placeholderCostomization(placeHolderText:AppMessage.shared.Otp)
        self.newPasswordText.placeholderCostomization(placeHolderText: AppMessage.shared.NewPass)
        self.confirmPasswordText.placeholderCostomization(placeHolderText: AppMessage.shared.ConfirmPass)
        
        // Do any additional setup after loading the view.
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Eye Button Functionality--
    ////function for secure entry textfield in password field
    @IBAction func passwodEyeActionButton(_ sender: UIButton) {
        sender.isSelected = !sender.isSelected
        if sender.isSelected{
            newPasswordText.isSecureTextEntry = false
        }else{
            newPasswordText.isSecureTextEntry = true
        }
    }
    
    // MARK: Eye Button Functionality--
    ////function for secure entry textfield in confirm password field
    @IBAction func confirmPassWordActionButton(_ sender: UIButton) {
        sender.isSelected = !sender.isSelected
        if sender.isSelected{
            confirmPasswordText.isSecureTextEntry = false
        }else{
            confirmPasswordText.isSecureTextEntry = true
        }
    }
    // MARK: Back Button Action--
    /// Create Function For Navigate to forgot password Controller
    /// - Parameter sender : UIButton
    @IBAction func backButton(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    // MARK: Register APi Call
    /// Create Function For Calling Login Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func continueButton(_ sender: Any) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            registerApiCall()
        }
    }
    // MARK: Create function for calling register api--
    func registerApiCall(){
        ResetPasswordViewModels.resetPasswordApi(otp: otpText.text ?? DefaultValue.emptyString.rawValue, email: email ?? DefaultValue.emptyString.rawValue, password: newPasswordText.text ?? DefaultValue.emptyString.rawValue, confirm_password: confirmPasswordText.text ?? DefaultValue.emptyString.rawValue) { UserResetDetails, isSuccess in
            if isSuccess{
                let vc = self.storyboard?.instantiateViewController(withIdentifier: ResetViewController.identifier)as! ResetViewController
                self.navigationController?.pushViewController(vc, animated: true)
            }else{
                self.showSimpleAlert(message: UserResetDetails?.message ?? DefaultValue.errorMsg.rawValue)
            }
            //
        }
    }
    // MARK: resend OTP APi Call--
    /// Create Function For Calling Login Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func resendOTP(_ sender: Any) {
        ResetPasswordViewModels.resendOTPApi(email: email ?? DefaultValue.emptyString.rawValue) { UserResendOTP, isSuccess in
            if isSuccess{
                self.showSimpleAlert(message: UserResendOTP?.message ?? DefaultValue.errorMsg.rawValue)
            }else{
                self.showSimpleAlert(message: UserResendOTP?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: TextFields Validation
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation()->String?{
        guard !(String.getString(self.newPasswordText.text).isEmpty) else{return AppMessage.shared.PleaseEnterPassword}
        guard String.getString(self.newPasswordText.text).isValidPassword() else{return AppMessage.shared.PleaseEnterValidPassword}
        guard !(String.getString(self.confirmPasswordText.text).isEmpty) else{return AppMessage.shared.PleaseEnterConfirmPassword}
        guard self.confirmPasswordText.text == self.newPasswordText.text else{return AppMessage.shared.PasswordAndConfirmPassword}
        guard String.getString(self.confirmPasswordText.text).isValidPassword() else{return AppMessage.shared.MismatchPassword}
        
        return nil
        
    }
}
///Create function for set the maximum character in textfield--
/// - Parameter textField: UITextField
extension ResetPasswordViewController:UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        let currentText = (textField.text! as NSString).replacingCharacters(in: range, with: string)
        if textField == otpText{
            if currentText.count >= 7{
                return false
            }
            let ACCEPTABLE_CHARACTERS = DefaultValue.DigitRange.rawValue
            switch textField {
            case otpText:
                let cs = NSCharacterSet(charactersIn: ACCEPTABLE_CHARACTERS).inverted
                let filtered = string.components(separatedBy: cs).joined(separator: DefaultValue.emptyString.rawValue)
                return (string == filtered)
            default:
                return true
            }
        }
        return true
    }
}
