//
//  ManagePromoterViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import UIKit

class ManagePromoterViewController: UIViewController{
    // MARK: IBOutlets--
    @IBOutlet weak var tableViewPromoterData: UITableView!
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var lblNoRecord: UILabel!
    // MARK: Variable Initializer--
    var managePromoterViewModel = ManagePromoterViewModel()
    var managePromoterData: [ManagePromoterDetail]?
    var searchPromoterData: [ManagePromoterDetail]?
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
        tableViewPromoterData.delegate = self
        tableViewPromoterData.dataSource = self
        searchTextField.delegate = self
    }
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated) // No need for semicolon
        searchTextField.text = ""
        managePromoterApi()
        self.tableViewPromoterData.reloadData()
    }
    // MARK: - Create function for call Change Promoter status
    func changePromoterStatus(userId:Int, status:Int){
        managePromoterViewModel.callChangePromoterStatus(userID: userId, status: status) {[weak self] promterStatus, isSuccess in
            if isSuccess == true {
                self?.managePromoterApi()
                self?.showSimpleAlert(message: promterStatus?.data?.message ?? DefaultValue.errorMsg.rawValue)
                
            } else {
                self?.showSimpleAlert(message: promterStatus?.data?.message ?? DefaultValue.errorMsg.rawValue)
                self?.tableViewPromoterData.reloadData()
            }
        }
}
    
    // MARK: Create function for calling Manage Promoter Api--
    func managePromoterApi(){
        managePromoterViewModel.callManagePromoterApi { [weak self] ManagePromoterDetails, isSuccess in
            if isSuccess == true{
                if ManagePromoterDetails.data?.count == 0{
                    self?.lblNoRecord.isHidden = false
                }else{
                    self?.lblNoRecord.isHidden = true
                    self?.managePromoterData = ManagePromoterDetails.data
                    self?.searchPromoterData = ManagePromoterDetails.data
                    self?.tableViewPromoterData.reloadData()
                }
            }else{
            }}}
    // MARK: Create action for navigate to previous Screen--
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
        
    }
    // MARK: Create function for navigate to Update User Screen--
    @objc func tapEditBtn(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: UpdateUserViewController.identifier) as! UpdateUserViewController
        vc.isFromUser = false
        vc.updateUserViewModel.id = searchPromoterData?[sender.tag].id ?? 0
        self.navigationController?.pushViewController(vc , animated: true)
    }
    @objc func tapDeleteBtn(sender: UIButton){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeletePromoter, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
            self.managePromoterViewModel.callDeletePromoterApi(id: self.searchPromoterData?[sender.tag].id ?? 0) { [self] deleteData, isSuccess in
                if isSuccess == true{
                    self.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                    managePromoterApi()
                    self.tableViewPromoterData.reloadData()
                }else{
                    self.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                }
                
            }}))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    // MARK: - Create function for change Status of Promoter
    @objc func changePromoterStatus(_ sender : UISwitch!) {
        PromoterStatusForEvent(index: sender.tag)
    }
    // MARK: - status changed for promoter
    func PromoterStatusForEvent(index: Int) {
        var userID : Int?
        var preStatus:Int?
        
        userID = searchPromoterData?[index].id  ?? 0
        preStatus = searchPromoterData?[index].isVerified ?? 0
        var msg = ""
        var toLiveStatus = 0
        switch preStatus {
        case 0:
            msg = AppMessage.shared.VerifyPromoter
            toLiveStatus = 1
        case 1:
            msg = AppMessage.shared.DeclinePromoter
            toLiveStatus = 0
        default:
            break
        }
        let alert = UIAlertController(title: Alert.projectName, message: msg, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.changeStatus, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.changePromoterStatus(userId: userID ?? 0, status: toLiveStatus)
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.tableViewPromoterData.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
    }

}

// MARK: Create Extension for tableview Delegate and DataSource--
extension ManagePromoterViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if searchPromoterData?.count == 0{
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return searchPromoterData?.count ?? 0
        
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: ManagePromoterTableViewCell.identifier) as! ManagePromoterTableViewCell
        let data = searchPromoterData?[indexPath.row]
        cell.lblName.text = (data?.firstName ?? DefaultValue.emptyString.rawValue).capitalized + " " + (data?.lastName ?? DefaultValue.emptyString.rawValue).capitalized
        cell.labelEmail.text = data?.email
        cell.lblPhone.text = data?.phoneNo
        cell.editButton.tag = indexPath.row
        cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
        cell.deleteButton.tag = indexPath.row
        cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
        cell.changePromoterStatus(ownPromoter: data?.isVerified ?? 0)
        cell.verifyPromoter.addTarget(self, action: #selector(self.changePromoterStatus(_:)), for: .valueChanged)
        cell.verifyPromoter.tag = indexPath.row
        return cell
    }
}
// MARK: Extesion for search data with search bar--
extension ManagePromoterViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                searchPromoterData = managePromoterData?.filter({ values in
                    return (values.firstName ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.lastName ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.email ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                })
            }else{
                searchPromoterData = managePromoterData
            }
            tableViewPromoterData.reloadData()
        }
        return true
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
