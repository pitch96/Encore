//
//  ForgetPasswordViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 30/11/22.
//

import UIKit

class ForgetPasswordViewController: UIViewController,UITextFieldDelegate {

    @IBOutlet weak var confirmButton: UIButton!
    @IBOutlet weak var emailText: UITextField!
    @IBOutlet weak var emailView: CustomView!
    
    
    lazy var forgetPasswordViewModel: ForgetPasswordViewModel = {
        var forgetPasswordViewModel = ForgetPasswordViewModel()
        return forgetPasswordViewModel
        
    }()
    var modelObject : ForgetPasswordModel?

    override func viewDidLoad() {
        super.viewDidLoad()

        emailText.delegate = self
        confirmButton.layer.cornerRadius = 10
    }
    
    @IBAction func ClickedForget(_ sender: Any) {
        print(self.emailText.text ?? DefaultValue.emptyString)
        
        forgetPasswordViewModel.callForgetPasswordApi(email: emailText.text ?? DefaultValue.emptyString) { [unowned self] UserForgetDetails in
            if UserForgetDetails?.statusCode == 200 {
                let vc = self.doNavigation(identifier: Identifier.FSGResetPasswordViewController, controller: ResetPasswordViewController.self)
                vc.email = emailText.text ?? ""
            }else{
                self.showSimpleAlert(message: UserForgetDetails?.message ?? DefaultValue.emptyString)
            }
            
            
//           
        }
    }
    
    @IBAction func backButton(_ sender: Any) {
        let vc = self.navigationController?.popViewController(animated: true)
    }
}
