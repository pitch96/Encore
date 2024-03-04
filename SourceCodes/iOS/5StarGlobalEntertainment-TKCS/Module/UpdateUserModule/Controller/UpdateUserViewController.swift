//
//  UpdateUserViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import UIKit

class UpdateUserViewController: UIViewController {
    
    // MARK: IBOutlets--
    @IBOutlet weak var updateUserButton: UIButton!
    @IBOutlet weak var lblController: UILabel!
    @IBOutlet weak var firstNameTextField: UITextField!
    @IBOutlet weak var lastNameTextField: UITextField!
    @IBOutlet weak var userTypeTextField: UITextField!
    @IBOutlet weak var emailTextField: UITextField!
    @IBOutlet weak var phoneNumberTextField: UITextField!
    @IBOutlet weak var companyNametextField: UITextField!
    
    // MARK: Variable Initializer--
    var isFromUser = false
    var updateUserModel : UpdateUserModel?
    lazy var updateUserViewModel:UpdateUserViewModel = {
        var updateUserViewModel = UpdateUserViewModel()
        return updateUserViewModel
    }()
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        phoneNumberTextField.delegate = self
        firstNameTextField.delegate = self
        lastNameTextField.delegate = self
        companyNametextField.delegate = self
        userTypeTextField.isUserInteractionEnabled = false
        emailTextField.isUserInteractionEnabled = false
        userTypeTextField.delegate = self
        if isFromUser {
            lblController.text = DefaultValue.updatedUser.rawValue
            updateUserButton.setTitle(DefaultValue.updatedUser.rawValue, for: .normal)
        }else{
            lblController.text = DefaultValue.updatedPromoter.rawValue
            updateUserButton.setTitle(DefaultValue.updatedPromoter.rawValue, for: .normal)
        }
        //getManageUserAPi()
        
    }
    // MARK: Create function for call Get User APi--
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        getManageUserAPi()// No need for semicolon
    }
    // MARK: Create a function for calling get user Api--
    func getManageUserAPi(){
        updateUserViewModel.callGetUserApi(id: updateUserViewModel.id ) { getUserDetail, isSuccess in
            if isSuccess == true{
                
                self.firstNameTextField.text = getUserDetail?.data?.firstName
                self.lastNameTextField.text = getUserDetail?.data?.lastName
                if getUserDetail?.data?.userType == 2{
                    self.userTypeTextField.text = "User"
                }else {
                    self.userTypeTextField.text = "Promoter"
                }
                self.emailTextField.text = getUserDetail?.data?.email
                self.phoneNumberTextField.text = getUserDetail?.data?.phoneNo
                self.companyNametextField.text = getUserDetail?.data?.companyName
            }else{
                self.showSimpleAlert(message: getUserDetail?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Navigate To Manage user Controller
    /// Create Function For Navigate to Manage user Controller from Update user
    /// - Parameter sender : UIButton
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Update user APi Call--
    ////// Create Function For Calling update user Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func updateUserButtonAction(_ sender: UIButton) {
        callUpdateUserApi()
    }
// MARK: Create a function for Calling Update User Api--
    func callUpdateUserApi(){
        updateUserViewModel.callUpdateUserApi(id: updateUserViewModel.id, fName: firstNameTextField.text ?? DefaultValue.emptyString.rawValue, lName: lastNameTextField.text ?? DefaultValue.emptyString.rawValue, phoneNum: phoneNumberTextField.text ?? DefaultValue.emptyString.rawValue, companyName: companyNametextField.text ?? DefaultValue.emptyString.rawValue) {[weak self]  updateUser, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: updateUser?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                self?.showSimpleAlert(message: updateUser?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
}
// MARK: Extension for phone number validation--
extension UpdateUserViewController{
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
// MARK: Extendion for set maximum limit in textfield--
extension UpdateUserViewController: UITextFieldDelegate{
    ///Create function for set the number format in phone number textfield
    /// - Parameter textField: UITextField
    func textFieldDidChangeSelection(_ textField: UITextField) {
        phoneNumberTextField.text = self.format(with: DefaultValue.numberFormat.rawValue, phone: phoneNumberTextField.text ?? DefaultValue.emptyString.rawValue)
    }
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
        case userTypeTextField:
            guard let textFieldText = userTypeTextField.text,
                let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                    return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 25
        case companyNametextField:
            guard let textFieldText = companyNametextField.text,
                let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                    return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 50
        default:
            return true
        }
        
    }
}
