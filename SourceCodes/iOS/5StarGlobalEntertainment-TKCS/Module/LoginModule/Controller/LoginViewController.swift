//
//  LoginVC.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 18/11/22.
//

import UIKit
import LocalAuthentication
import IQKeyboardManagerSwift


class LoginViewController: UIViewController {
    //    userIntrface
    // MARK: @IBOutlets
    @IBOutlet weak var viewLogin: UIView!
    @IBOutlet weak var viewPassword: UIView!
    @IBOutlet weak var viewEmail: UIView!
    @IBOutlet weak var paswwordTextField: UITextField!
    @IBOutlet weak var emailTextField: UITextField!
    @IBOutlet weak var loginButton: UIButton!
    @IBOutlet weak var touchIdButton: UIButton!
    @IBOutlet weak var lblTouchId: UIButton!
    
    // MARK: Variable Initialization
    lazy var viewModel: UserLoginViewModel = {
        var viewModel = UserLoginViewModel()
        return viewModel
    }()
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        // set corner radius to button
        self.loginButton.layer.cornerRadius = 10
        //set placeholder text for email and password
        self.emailTextField.placeholderCostomization(placeHolderText: AppMessage.shared.Email)
        self.paswwordTextField.placeholderCostomization(placeHolderText: AppMessage.shared.Password)
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: EYE Button Action
    /// Create Function For Hide And Show Password
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func eyeButtonAction(_ sender: UIButton) {
        sender.isSelected = !sender.isSelected
        if sender.isSelected{
            paswwordTextField.isSecureTextEntry = false
        }else{
            paswwordTextField.isSecureTextEntry = true
        }
    }
    // MARK: - Navigate To Forget Password
    /// Creare Function For Navigate To Forget Password Creen
    /// - Parameter sender: UIButton
    @IBAction func forgetButtonAction(_ sender: UIButton) {
        _ =  doNavigation(identifier: ForgetPasswordViewController.identifier, controller: ForgetPasswordViewController.self)
    }
    // MARK: - Login APi Call
    /// Create Function For Calling Login Api and textfield validation
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func loginButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            callingLoginAPi(email: emailTextField.text ?? DefaultValue.emptyString.rawValue, password: paswwordTextField.text ?? DefaultValue.emptyString.rawValue)
        }
    }
    // MARK: - touchId Button Action
    /// Create Function For finger print authentication
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func touchIdButtonAction(_ sender: UIButton) {
        manageTouchIDAuthentication()
      
    }
    // MARK: - Create function for touch-Id  Login
    private func manageTouchIDAuthentication(){
        let context = LAContext()
                var error: NSError?
                
                self.view.endEditing(true)
                
                var btype = ""
//                  if biometricType() == .face { btype = "Face ID" }
                  if biometricType() == .touch { btype = "Touch ID" }
                else { return }
                
                if let email = UserDefaults.standard.string(forKey: "loginEmail"), let password = UserDefaults.standard.string(forKey: "loginPassword") {
                    if context.canEvaluatePolicy(.deviceOwnerAuthenticationWithBiometrics, error: &error) {
                        let reason = "The Encore Event App uses \(btype) to make logging in easier."
                        
                        context.evaluatePolicy(.deviceOwnerAuthenticationWithBiometrics, localizedReason: reason) { success, error in
                            DispatchQueue.main.asyncAfter(deadline: .now() + 1.0) {
                                if success {
                                    // Populate Email and Password into text inputs
                                    // Submit login
                                    self.callingLoginAPi(email:email, password:password)
                                    //self.authenticateLogin(email: email, password: password)
                                }
                                else {
                                    let ac = UIAlertController(title: "Authentication Failed", message: "Unable to authenticate using \(btype). Please try again.", preferredStyle: .alert)
                                    ac.addAction(UIAlertAction(title: "OK", style: .default))
                                    self.present(ac, animated: true)
                                }
                            }
                        }
                    }
                    else {
                        // REMOVE BUTTON SO THIS IS NEVER TRIGGERED
                        let ac = UIAlertController(title: "\(btype) Unavailable", message: "Your device does not support \(btype) authentication.", preferredStyle: .alert)
                        ac.addAction(UIAlertAction(title: "OK", style: .default))
                        self.present(ac, animated: true)
                    }
                }
                else {
                    let ac = UIAlertController(title: "Authentication Failed", message: "You must first successfully login to enable \(btype) login.", preferredStyle: .alert)
                    ac.addAction(UIAlertAction(title: "OK", style: .default))
                    self.present(ac, animated: true)
                }
        
    }
    // MARK: create function for calling Login api--
    func callingLoginAPi(email:String, password:String){
        viewModel.callLogInUpApi(email: email, password: password) { [unowned self] UserDetailsData, isSuccess in
            if isSuccess{
                UserDefaults.standard.set(email, forKey: "loginEmail")
                UserDefaults.standard.set(password, forKey: "loginPassword")

                moveToTabBarController()
//                KeychainService.sharedInstance.save(userEmail, key: Constant.KeychainService.email)
//                 KeychainService.sharedInstance.save(userPassword, key: Constant.KeychainService.password)
            }else {
                self.showSimpleAlert(message: UserDetailsData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Navigate To SignUp Controller
    /// Create Function For Navigate to SIgnUp View Controller
    /// - Parameter sender : UIButton
    @IBAction func createAccountButtonAction(_ sender: UIButton) {
        _ = doNavigation(identifier: SignUpViewController.identifier, controller: SignUpViewController.self)
    }
    // MARK: - TextFields Validation
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation()->String?{
        guard !(String.getString(self.emailTextField.text).isEmpty) else{return AppMessage.shared.pleaseEnterEmailAddress}
        guard String.getString(self.emailTextField.text).isEmail() else{return AppMessage.shared.pleaseEnterValidEmailAddress}
        return nil
        
    }
    // MARK: - Create function for move to tab bar Controller
    func moveToTabBarController(){
        TokenService.sharedInstance.getUserLogin(bool: true, key: KeysDefaults.isLogin)
        let vc = AppDelegate.sharedInstance.storyBoard.instantiateViewController(withIdentifier:FSGHomeTabBarController.identifier) as! FSGHomeTabBarController
        let tabVC = UINavigationController(rootViewController: vc)
        tabVC.setNavigationBarHidden(true, animated: false)
        if #available(iOS 13.0, *) {
            SceneDelegate.shared?.window?.rootViewController = tabVC
            SceneDelegate.shared?.window?.makeKeyAndVisible()
        } else {
            AppDelegate.sharedInstance.window?.rootViewController = tabVC
            AppDelegate.sharedInstance.window?.makeKeyAndVisible()
        }
    }
}
