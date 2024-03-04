//
//  SignUpVc.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 18/11/22.
//

import UIKit

class SGSignUpViewController: UIViewController {
    @IBOutlet weak var clientButton: UIButton!
    @IBOutlet weak var userButton: UIButton!
   
    // MARK: OUTLETS AND VARRIABLES------------
    @IBOutlet weak var viewConfirmPassword: UIView!
    @IBOutlet weak var viewPassword: UIView!
    @IBOutlet weak var viewCompanyName: UIView!
    @IBOutlet weak var viewPhoneNumber: UIView!
    @IBOutlet weak var viewEmail: UIView!
    @IBOutlet weak var viewLastName: UIView!
    @IBOutlet weak var viewFirstName: UIView!
    @IBOutlet weak var signUpBtn: UIButton!
    @IBOutlet weak var txtConfirmPassword: UITextField!
    @IBOutlet weak var txtPassword: UITextField!
    @IBOutlet weak var txtCompanyName: UITextField!
    @IBOutlet weak var txtPhoneNumber: UITextField!
    @IBOutlet weak var txtEmail: UITextField!
    @IBOutlet weak var txtLastName: UITextField!
    @IBOutlet weak var txtFirstName: UITextField!
    @IBOutlet weak var backBtn: UIButton!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.userButton.isSelected = true
        
        self.signUpBtn.layer.cornerRadius = 10
        txtPhoneNumber.addTarget(self, action: #selector(UpdateNumber), for: .allEvents)
    }
    @objc func UpdateNumber(){
        txtPhoneNumber.text = self.format(with: "(XXX)-XXX-XXX", phone: txtPhoneNumber.text ?? "")
    }
    
    // MARK: select User and Client -----------
    @IBAction func selectedUser(_ sender: UIButton) {
        let buttonArray = [userButton,clientButton]
        buttonArray.forEach{
            $0?.isSelected = false
        }
        sender.isSelected = true
    }
    
    // MARK: Validation for textFileds---------
    func validation(){
        if String.getString(self.txtFirstName.text).isEmpty{
            self.showSimpleAlert(message:kAlertName )
            return
        }else if !String.getString(self.txtFirstName.text).isName(){
            self.showSimpleAlert(message:kValidName)
            return

        }else if String.getString(self.txtLastName.text).isEmpty{
            self.showSimpleAlert(message: kAlertLastName)
            return
        }else if !String.getString(self.txtLastName.text).isName(){
            self.showSimpleAlert(message: KAlertValidLastName)
            return
        }
        else if String.getString(self.txtEmail.text).isEmpty{
            self.showSimpleAlert(message: fsgMail)
            return
        }else if !String.getString(self.txtEmail.text).isEmail(){
            self.showSimpleAlert(message:fsgValidMail )
            return
        }
        else if  String.getString(self.txtPhoneNumber.text).isEmpty{
            self.showSimpleAlert(message: kPhoneNumber)
            return
        }else if !(!String.getString(self.txtPhoneNumber.text).isEmpty){
            self.showSimpleAlert(message:kValidPhoneNumber )
            return
        } else if !(!String.getString(self.txtCompanyName.text).isEmpty){
                self.showSimpleAlert(message:kAlertCompany )
                return
            }else if String.getString(self.txtCompanyName.text).isCompanyName(){
                self.showSimpleAlert(message: kAlertCompany)
                return
        }else if String.getString(self.txtPassword.text).isEmpty{
            self.showSimpleAlert(message: fsgEnterPassword)
            return
        }else if !String.getString(self.txtPassword.text).isPasswordValidate(){
            self.showSimpleAlert(message: kAlertValidPassword)
            return
        }else if String.getString(self.txtConfirmPassword.text).isEmpty{
            self.showSimpleAlert(message: kAlertConfirmPassword)
            return
        }
        else if (txtPassword.text != self.txtConfirmPassword.text){
            self.showSimpleAlert(message: KAlertValidConfirmPassword)
            return

        }
        else{

        }
        self.view.endEditing(true)
    }
   
    @IBAction func btnSignUp(_ sender: Any) {
        validation()
        self.navigationController?.popViewController(animated: true)
        
    }
    
    @IBAction func btnBack(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
}
// MARK: change phone number text-Style-------------
extension SGSignUpViewController{
    func format(with mask: String, phone: String) -> String {
            let numbers = phone.replacingOccurrences(of: "[^0-9]", with: "", options: .regularExpression)
            var result = ""
            var index = numbers.startIndex
            for ch in mask where index < numbers.endIndex {
                if ch == "X" {
                    result.append(numbers[index])
                    index = numbers.index(after: index)
                } else {
                    result.append(ch)
                }
            }
            return result
        }
     
}
