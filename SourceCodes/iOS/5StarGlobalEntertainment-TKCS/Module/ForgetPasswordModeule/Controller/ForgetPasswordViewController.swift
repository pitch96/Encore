//
//  ForgetPasswordViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import UIKit

class ForgetPasswordViewController: UIViewController,UITextFieldDelegate {
    // MARK: IBOutlets--
    @IBOutlet weak var confirmButton: UIButton!
    @IBOutlet weak var emailText: UITextField!
    @IBOutlet weak var emailView: CustomView!
    
    // MARK: Variable initializer--
    lazy var forgetPasswordViewModel: ForgetPasswordViewModel = {
        var forgetPasswordViewModel = ForgetPasswordViewModel()
        return forgetPasswordViewModel
    }()
    var modelObject : ForgetPasswordModel?
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        self.emailText.placeholderCostomization(placeHolderText: AppMessage.shared.Emails)
        emailText.delegate = self
        confirmButton.layer.cornerRadius = 10
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: forgot APi Call--
    /// Create Function For Calling forgot Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func ClickedForget(_ sender: Any) {
        debugPrint(self.emailText.text ?? DefaultValue.emptyString.rawValue)
        forgetPasswordViewModel.callForgetPasswordApi(email: emailText.text ?? DefaultValue.emptyString.rawValue) { [unowned self] UserForgetDetails, isSuccess in
            if isSuccess {
                let vc = self.doNavigation(identifier: ResetPasswordViewController.identifier, controller: ResetPasswordViewController.self)
                vc.email = emailText.text ?? DefaultValue.emptyString.rawValue
            }else{
                self.showSimpleAlert(message: UserForgetDetails?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Navigate To Login Controller
    /// Create Function For Navigate to Login View Controller
    /// - Parameter sender : UIButton
    @IBAction func backButton(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
}
