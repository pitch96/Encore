//
//  ResetPasswordViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import UIKit

class ResetPasswordViewController: UIViewController{
    var email:String?
    @IBOutlet weak var confirmPasswordText: UITextField!
    @IBOutlet weak var newPasswordText: UITextField!
    @IBOutlet weak var otpText: UITextField!
    
    
    let ResetPasswordViewModels = ResetPasswordViewModel()
    
    var modelObject : ResetPasswordModel?
    override func viewDidLoad() {
        super.viewDidLoad()
        otpText.delegate = self
        self.otpText.placeholderCostomization(placeHolderText: "OTP")
        self.newPasswordText.placeholderCostomization(placeHolderText: "New password")
       self.confirmPasswordText.placeholderCostomization(placeHolderText: "Confirm Password")
        
        // Do any additional setup after loading the view.
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }

    @IBAction func passwodEyeActionButton(_ sender: UIButton) {
        sender.isSelected = !sender.isSelected
        if sender.isSelected{
            newPasswordText.isSecureTextEntry = false
        }else{
            newPasswordText.isSecureTextEntry = true
        }
    }
    
    
    @IBAction func confirmPassWordActionButton(_ sender: UIButton) {
        sender.isSelected = !sender.isSelected
        if sender.isSelected{
            confirmPasswordText.isSecureTextEntry = false
        }else{
            confirmPasswordText.isSecureTextEntry = true
        }
    }
    @IBAction func backButton(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    
    @IBAction func continueButton(_ sender: Any) {
       
        let alertmessage = validation()
               if let alertmessage = alertmessage{
                   self.showSimpleAlert(message: alertmessage)
               }else{
                   ResetPasswordViewModels.resetPasswordApi(otp: otpText.text ?? DefaultValue.emptyString.rawValue, email: email ?? DefaultValue.emptyString.rawValue, password: newPasswordText.text ?? DefaultValue.emptyString.rawValue, confirm_password: confirmPasswordText.text ?? DefaultValue.emptyString.rawValue) { UserResetDetails in
                       if UserResetDetails?.statusCode == 200{
                           let vc = self.storyboard?.instantiateViewController(withIdentifier: Identifier.FSGResetViewController)as! ResetViewController
                           self.navigationController?.pushViewController(vc, animated: true)
                       }else{
                           self.showSimpleAlert(message: UserResetDetails?.message ?? DefaultValue.emptyString.rawValue)
                       }
                       //
                   }
               }
    }
    @IBAction func resendOTP(_ sender: Any) {
        ResetPasswordViewModels.resendPasswordApi(email: email ?? DefaultValue.emptyString.rawValue) { UserResendOTP in
            if UserResendOTP?.statusCode == 200 {
                self.showSimpleAlert(message: UserResendOTP?.message ?? DefaultValue.emptyString.rawValue)
            }else{
                self.showSimpleAlert(message: UserResendOTP?.message ?? DefaultValue.emptyString.rawValue)
            }
        }
        
    }
    func validation()->String?{
        guard !(String.getString(self.newPasswordText.text).isEmpty) else{return AppMessage.shared.PleaseEnterPassword}
        guard String.getString(self.newPasswordText.text).isValidPassword() else{return AppMessage.shared.PleaseEnterValidPassword}
        guard !(String.getString(self.confirmPasswordText.text).isEmpty) else{return AppMessage.shared.PleaseEnterConfirmPassword}
        guard self.confirmPasswordText.text == self.newPasswordText.text else{return AppMessage.shared.PasswordAndConfirmPassword}
        guard String.getString(self.confirmPasswordText.text).isPasswordValidate() else{return AppMessage.shared.MismatchPassword}
        
        return nil
        
    }
}
extension ResetPasswordViewController:UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        let currentText = (textField.text! as NSString).replacingCharacters(in: range, with: string)
        if textField == otpText{
            if currentText.count >= 7{
                return false
            }
            let ACCEPTABLE_CHARACTERS = "0123456789"
            switch textField {
            case otpText:
                let cs = NSCharacterSet(charactersIn: ACCEPTABLE_CHARACTERS).inverted
                let filtered = string.components(separatedBy: cs).joined(separator: "")
                return (string == filtered)
            default:
                return true
            }
        }
        return true
    }
}
