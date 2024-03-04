//
//  LoginVC.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 18/11/22.
//

import UIKit

class SGLoginViewController: UIViewController {
    
    @IBOutlet weak var txtPassword: UITextField!
    @IBOutlet weak var txtEmail: UITextField!
    @IBOutlet weak var loginBtn: UIButton!
    @IBOutlet weak var viewPassword: UIView!
    @IBOutlet weak var viewEmail: UIView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.loginBtn.layer.cornerRadius = 10
    }
    @IBAction func btnLogin(_ sender: Any) {
//        validation()
        let vc = UIStoryboard.init(name: "Main", bundle: Bundle.main).instantiateViewController(withIdentifier: "SDHomeTabBarController") as? SDHomeTabBarController
        self.navigationController?.pushViewController(vc!, animated: true)
    }
    @IBAction func btnForgetPassword(_ sender: Any) {
        
    }
    @IBAction func btnCreateAccount(_ sender: Any) {
            let vc = self.storyboard?.instantiateViewController(withIdentifier: "SGSignUpViewController")as! SGSignUpViewController
            self.navigationController?.pushViewController(vc, animated: true)
    }
    // MARK: Validation for textFileds---------
    func validation() -> Bool{
        if String.getString(self.txtEmail.text).isEmpty{
            self.showSimpleAlert(message:fsgMail )
            return false
        }else if !String.getString(self.txtEmail.text).isEmail(){
            self.showSimpleAlert(message:fsgValidMail )
            return false
        }else if String.getString(self.txtPassword.text).isEmpty{
            self.showSimpleAlert(message: fsgEnterPassword )
            return false
        }else if !String.getString(self.txtPassword.text).isValidPassword(){
            showSimpleAlert(message: fsgValidPassword)
            return false
        }
        return true
    }
    
}
