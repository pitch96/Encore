//
//  LoginVC.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 18/11/22.
//

import UIKit
import IQKeyboardManagerSwift
import MBProgressHUD

class FSGLoginViewController: UIViewController {
    
    @IBOutlet weak var paswwordText: UITextField!
    @IBOutlet weak var emailText: UITextField!
    @IBOutlet weak var loginBtn: UIButton!
    @IBOutlet weak var passwordView: UIView!
    @IBOutlet weak var emailView: UIView!
    
    lazy var viewModel: UserLoginViewModel = {
        var viewModel = UserLoginViewModel()
        return viewModel
        
    }()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.loginBtn.layer.cornerRadius = 10
        
    }
    @IBAction func btnLogin(_ sender: Any) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            viewModel.callLogInUpApi(email: emailText.text ?? DefaultValue.emptyString, password: paswwordText.text ?? DefaultValue.emptyString) { [unowned self] message in
                if let message = message{
                    self.showSimpleAlert(message: message)
                }else{
                     _ = self.doNavigation(identifier: Identifier.FSGHomeTabBarController, controller: FSGHomeTabBarController.self)
                }
            }
        }
        
    }
    
    
    @IBAction func btnForgetPassword(_ sender: Any) {
    }
    @IBAction func btnCreateAccount(_ sender: Any) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: Identifier.FSGSignUpViewController)as! FSGSignUpViewController
        self.navigationController?.pushViewController(vc, animated: true)
    }
    // MARK: Validation for textFileds---------
    func validation()->String?{
        guard !(String.getString(self.emailText.text).isEmpty) else{return "Please enter email."}
        guard String.getString(self.emailText.text).isEmail() else{return "Please enter valid email."}
        guard !(String.getString(self.paswwordText.text).isEmpty) else{return "Please enter password." }
        guard String.getString(self.paswwordText.text).isValidPassword() else{return "Password must be atleast character using 1 uppercase, lowercase and special character"}
        return nil
        
    }
}
