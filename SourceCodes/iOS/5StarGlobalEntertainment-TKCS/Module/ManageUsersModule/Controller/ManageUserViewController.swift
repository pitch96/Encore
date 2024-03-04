//
//  ManageUserViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import UIKit

class ManageUserViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var tableViewUserDetail: UITableView!
    @IBOutlet weak var noRecordFoundLbl: UILabel!
    @IBOutlet weak var searchTextField: UITextField!
   
    // MARK: Variable Initializer--
    var manageUserViewModel = ManageUserViewModel()
    var manageUserData: [ManageUserData]?
    var searchUserData: [ManageUserData]?
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
       
        // Do any additional setup after loading the view.
        tableViewUserDetail.delegate = self
        tableViewUserDetail.dataSource = self
        searchTextField.delegate = self
        noRecordFoundLbl.isHidden = false
    }
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        searchTextField.text = ""
        manageUserApi()
        self.tableViewUserDetail.reloadData()
    }
    // MARK: - Create a function for Calling ManageUser API
    func manageUserApi(){
        manageUserViewModel.callManageUsersApi { [weak self] ManageUserDetail, isSuccess in
            if isSuccess == true{
                if ManageUserDetail.data?.count == 0{
                    self?.noRecordFoundLbl.isHidden = false
                }else{
                    self?.noRecordFoundLbl.isHidden = true
                    self?.manageUserData = ManageUserDetail.data
                    self?.searchUserData = ManageUserDetail.data
                    self?.tableViewUserDetail.reloadData()
                }
            }else{
                self?.showSimpleAlert(message: ManageUserDetail.message ?? DefaultValue.errorMsg.rawValue)
            }}}
    // MARK: - Back Button Action
    ///Create function to navigate to back from Controller
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    @objc func tapEditBtn(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: UpdateUserViewController.identifier) as! UpdateUserViewController
        vc.isFromUser = true
    
        vc.updateUserViewModel.id = searchUserData?[sender.tag].id ?? 0
        self.navigationController?.pushViewController(vc , animated: true)
    }
    // MARK: - Button action Delete User APi Call
    /// Create Function For Delete User
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapDeleteBtn(sender: UIButton){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeleteUser, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
            self.manageUserViewModel.callDeleteUserApi(id: self.searchUserData?[sender.tag].id ?? 0) {[weak self] deleteData, isSuccess in
                if isSuccess == true {
                    self?.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                    self?.manageUserApi()
                    self?.tableViewUserDetail.reloadData()
                }else{
                    self?.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                }
            }}))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
}
    // MARK: - Extension for Tableview Delegate and Datasource
extension ManageUserViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if searchUserData?.count == 0{
            noRecordFoundLbl.isHidden = false
        }else{
            noRecordFoundLbl.isHidden = true
        }
        return searchUserData?.count ?? 0
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: ManageUsersTableViewCell.identifier, for: indexPath) as! ManageUsersTableViewCell
       
        let data = searchUserData?[indexPath.row]
        cell.lblName.text = (data?.firstName ?? DefaultValue.emptyString.rawValue) + " " + (data?.lastName ?? DefaultValue.emptyString.rawValue)
        cell.lblEmail.text = data?.email
        cell.lblPhone.text = data?.phoneNo
        cell.editButton.tag = indexPath.row
        cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
        cell.deleteButton.tag = indexPath.row
        cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
        return cell
    }
}
// MARK: - Create function for textfield delegate
///create function for searching in tableview
extension ManageUserViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                searchUserData = manageUserData?.filter({ values in
                    return (values.firstName ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.lastName ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.email ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                })
            }else{
                searchUserData = manageUserData
            }
            tableViewUserDetail.reloadData()
        }
        return true
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
