//
//  ManageTicketViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/02/23.
//

import UIKit

class ManageTicketViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var seachTextField: UITextField!
    @IBOutlet weak var ManageTicketTableView: UITableView!
    @IBOutlet weak var lblNoRecord: UILabel!
    
    // MARK: Variable initializer--
    var manageTicketViewModel = ManageTicketViewModel()
    var manageticketData: [ManageTicketData]?
    var searchTicketData: [ManageTicketData]?
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        ManageTicketTableView.delegate = self
        ManageTicketTableView.dataSource = self
        seachTextField.delegate = self
       
    }
    // MARK: viewWillAppear--
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        seachTextField.text = ""
        getTicketDetails()
        ManageTicketTableView.reloadData()
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Create function for calling get Ticket APi--
    func getTicketDetails(){
        manageTicketViewModel.callManageTicketApi {[weak self] ticketData, isSuccess in
            if isSuccess == true{
                if ticketData.data?.count == 0{
                    self?.lblNoRecord.isHidden = false
                }else{
                    self?.lblNoRecord.isHidden = true
                    self?.manageticketData = ticketData.data
                    self?.searchTicketData = ticketData.data
                    self?.ManageTicketTableView.reloadData()
                }
            }else{
                self?.showSimpleAlert(message: ticketData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Edit Button Action--
    ///Create function for navigate to update ticket Screen
    ////// - Parameter sender: UIButton
    /// return : nil
    @objc func tapEditBtn(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: UpdateTicketViewController.identifier) as! UpdateTicketViewController
        vc.updateTicketViewModel.id = searchTicketData?[sender.tag].id ?? 0
        vc.eventID = searchTicketData?[sender.tag].eventID ?? 0
        vc.updateTicketViewModel.eventTitle = searchTicketData?[sender.tag].event?.eventTitle?.capitalized ?? DefaultValue.emptyString.rawValue
        vc.updateTicketViewModel.price = searchTicketData?[sender.tag].price ?? 0
        self.navigationController?.pushViewController(vc , animated: true)
    }
    // MARK: Button action Delete User APi Call--
    /// Create Function For Delete Ticket
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapDeleteBtn(sender: UIButton){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeleteTicket, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
            self.manageTicketViewModel.callDeleteTicketApi(id: self.searchTicketData?[sender.tag].id ?? 0) {[weak self] deleteData, isSuccess in
                if isSuccess == true {
                    self?.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                    self?.ManageTicketTableView.reloadData()
                    self?.getTicketDetails()
                    
                }else{
                    self?.showSimpleAlert(message: deleteData?.message ?? DefaultValue.errorMsg.rawValue)
                }
            }}))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
        
    }
    // MARK: Switch Button Action-
    ///Create a function for change status of switch button
    @objc func ticketStatusChanged(_ sender : UISwitch!){
        debugPrint("AllEvent:- \(sender.tag)")
        let eventID = manageticketData?[sender.tag].id ?? 0
        let preStatus = manageticketData?[sender.tag].status ?? 0
        var message = DefaultValue.emptyString.rawValue
        var toLiveStatus = 0
        switch preStatus {
        case 0:
            message = AppMessage.shared.EnterActivateTicket
            toLiveStatus = 1
        case 1:
            message = AppMessage.shared.EnterDeactivateTicket
            toLiveStatus = 0
        default:
            break
        }
        let alert = UIAlertController(title: Alert.projectName, message: message, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action:UIAlertAction!) in
            self.changeTicketStatus(eventID: eventID, status: toLiveStatus)
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.ManageTicketTableView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
    }
    // MARK: Create function for calling ticket Status Api--
    func changeTicketStatus(eventID:Int, status:Int){
        manageTicketViewModel.callGetTicketStatusApi(eventId: eventID, status: status) { [weak self] data, isSucess in
            if isSucess{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: data?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
                self?.getTicketDetails()
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.errorMsg.rawValue)
            }else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.errorMsg.rawValue)
                self?.ManageTicketTableView.reloadData()
            }}}
    // MARK: Back Button Action--
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
}
// MARK: Create extension for Tableview Delegate and DataSource method--
extension ManageTicketViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if searchTicketData?.count == 0 {
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return searchTicketData?.count ?? 0
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: ManageTicketTableViewCell.identifier) as! ManageTicketTableViewCell
        let data = searchTicketData?[indexPath.row]
        cell.lblTicketTitle.text = data?.ticketTitle
        cell.lblEventTitle.text = data?.event?.eventTitle?.capitalized
        cell.lblTicketType.text = "Ticket Type: \(data?.ticketType ?? DefaultValue.emptyString.rawValue)"
        cell.lblTicketStatus.text = "Ticket Status: \(data?.ticketStatus ?? DefaultValue.emptyString.rawValue)"
        cell.lblPrice.text = "Price:   $\(data?.price ?? 0)"
        cell.editButton.tag = indexPath.row
        cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
        cell.deleteButton.tag = indexPath.row
        cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
        cell.showTicketStatus(status: data?.status ?? 0)
        cell.buttonSwitch.addTarget(self, action: #selector(self.ticketStatusChanged(_:)), for: .valueChanged)
        cell.buttonSwitch.tag = indexPath.row
        return cell
    }
}
// MARK: create extension for Textfield Delegate--
///create function for searching using keyword in search box
extension ManageTicketViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = seachTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                searchTicketData = manageticketData?.filter({ values in
                    return (values.ticketTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.event?.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.ticketType ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())})
            }else{
                searchTicketData = manageticketData
            }
            ManageTicketTableView.reloadData()
        }
        return true
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        seachTextField.returnKeyType = UIReturnKeyType.search
        seachTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
