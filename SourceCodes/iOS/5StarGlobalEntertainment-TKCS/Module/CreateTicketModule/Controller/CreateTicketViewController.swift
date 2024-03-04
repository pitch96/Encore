//
//  CreateTicketViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 07/01/23.
//

import UIKit
import iOSDropDown

class CreateTicketViewController: UIViewController {
    // MARK: IBOutles--
    @IBOutlet weak var tikcetTableView: UITableView!
    @IBOutlet weak var dropDownTextField: DropDown!
    @IBOutlet weak var tableViewHeight: NSLayoutConstraint!
    // MARK: Variable initializer--
    var sectionCount : Int = 1
    let datePicker = UIDatePicker()
    var manageEvent = ManageEventViewModel()
    var getList : [ManageEventModelDetail]?
    var createTicketViewModel = CreateTicketViewModel()
    var createTicketModel : CreateTicketModel?
    var getTicketData : [ManageTicketData]?
    var selectedEventId : Int?
    static var createdTicketList = [CreateTicket()]
    var selectedEventEndDate: Date?
    var eventEndDate = DefaultValue.emptyString.rawValue
    var eventEndTime = DefaultValue.emptyString.rawValue
    
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        selectEventDropDown()
        self.tikcetTableView.delegate = self
        self.tikcetTableView.dataSource = self
        manageEventAPiCall()
    }
    // MARK: Create Function for DropDown List-
    func selectEventDropDown(){
        //selectedEventEndDate
        dropDownTextField.delegate = self
        dropDownTextField.isUserInteractionEnabled = true
        dropDownTextField.didSelect{(selectedText , index ,id) in
            self.dropDownTextField.text = selectedText
            self.selectedEventId = self.getList?[index].id ?? 0
            
            if let endDate = self.getList?[index].endDate {
                self.eventEndDate = endDate
            }
            if let endTime = self.getList?[index].endTime {
                self.eventEndTime = endTime
            }
        }
    }
    // MARK: Create function for convert time&Date --
    func convertStringToDate(date:String)->Date?{
        let dateFormatter = DateFormatter()
          dateFormatter.locale = Locale(identifier: "en_US_POSIX") // set locale to reliable US_POSIX
        dateFormatter.dateFormat = DefaultValue.inputDateFormat.rawValue
          let newDate = dateFormatter.date(from:date)
          return newDate
        
    }
    override func viewDidDisappear(_ animated: Bool) {
        CreateTicketViewController.createdTicketList = [CreateTicket()]
    }
    // MARK: Create function for calling event API to get list of event details--
    func manageEventAPiCall(){
        self.manageEvent.calllManageEventApi {[weak self] manageEventDetails, isSuccess in
            if isSuccess == true{
               self?.getList = manageEventDetails.data
                if let nameList = self?.getList?.map({$0.eventTitle}) as? [String] {
                    self?.dropDownTextField.optionArray = nameList
                }
                if let nameList = self?.getList?.map({$0.id}) as? [Int] {
                    self?.dropDownTextField.optionIds = nameList
                }
            }else{
                self?.showSimpleAlert(message: manageEventDetails.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Navigaion button Action--
    /// Create Function For back to HomeView Controller
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Cancel button Action--
    /// Create Function For back to view controller
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func cancelTicketAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Create function for call Create Ticket APi--
    ///create action for calling Api and Validation
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func saveTicketAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            createTicketAPiCall()
        }
    }
     // MARK: TextFields Validation--
    /// Create Function For TextField Validation
   /// - Returns: String(Optional)
    func validation()-> String?{
        guard !(String.getString(self.dropDownTextField.text).isEmpty) else{return AppMessage.shared.EnterEventTitle}
        guard !(String.getString(CreateTicketViewController.createdTicketList.first?.ticketTitle).isEmpty) else{return AppMessage.shared.EnterTicketTitle}
        guard !(String.getString(CreateTicketViewController.createdTicketList.first?.ticketType).isEmpty) else{return AppMessage.shared.EnterTicketType}
        guard !(String.getString(CreateTicketViewController.createdTicketList.first?.ticketQty).isEmpty) else{return AppMessage.shared.EnterTicketQuantity}
        if CreateTicketViewController.createdTicketList.first?.ticketType == DefaultValue.Paid.rawValue{
            
            guard !(String.getString(CreateTicketViewController.createdTicketList.first?.ticketPrice).isEmpty)  else{return AppMessage.shared.EnterTicketPrice}
        }
        guard (CreateTicketViewController.createdTicketList.first?.ticketPrice != 0) else {return AppMessage.shared.EnterValidPrice}
        guard !(String.getString(CreateTicketViewController.createdTicketList.first?.endDate).isEmpty) else{return AppMessage.shared.EnterEndDate}
        let tEndDate =  CreateTicketViewController.createdTicketList.first?.endDate ?? DefaultValue.emptyString.rawValue
        let ticketEndDate = self.convertStringToDate(date: eventEndDate)
        let writtenDate = self.convertStringToDate(date: tEndDate)
        if (writtenDate ?? Date()) > (ticketEndDate ?? Date()) {
            return AppMessage.shared.EnterValidEndDate
        }
        guard !(String.getString(CreateTicketViewController.createdTicketList.first?.endTime).isEmpty) else{return AppMessage.shared.EnterEndTime}
        return nil
    }
    // MARK: Create function for calling create ticket Api--
    func createTicketAPiCall(){
        
        let title = CreateTicketViewController.createdTicketList.first?.ticketTitle ?? DefaultValue.emptyString.rawValue
        let type = CreateTicketViewController.createdTicketList.first?.ticketType ?? DefaultValue.emptyString.rawValue
        let qn = CreateTicketViewController.createdTicketList.first?.ticketQty ?? DefaultValue.emptyString.rawValue
        let price = String(describing: CreateTicketViewController.createdTicketList.first?.ticketPrice ?? 0.0)
        let et = CreateTicketViewController.createdTicketList.first?.endTime ?? DefaultValue.emptyString.rawValue
        let ed = CreateTicketViewController.createdTicketList.first?.endDate ?? DefaultValue.emptyString.rawValue
        let userID = (UserDefaults.standard.value(forKey: DefaultValue.UserID.rawValue) as? Int) ?? 0
        createTicketViewModel.callCreateTicketApi(eventId: selectedEventId ?? 0, ticketTitle: title, ticketType: type, totalQty: qn, ticketPrice: price, endDate: ed, endTime: et, userId: userID) {[weak self] data, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: data?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Delete Button Action--
    ///Create action for delete specific cell from tableView
    /// - Parameter sender: UIButton
    /// /// return : nil
    @objc func deleteActionButton(sender: UIButton) {
        
//                if createdTicketList.count > 1{
//                    createdTicketList.remove(at: sender.tag)
//                }
//               tableViewHeight.constant = CGFloat(320*createdTicketList.count)
//                tikcetTableView.reloadData()
        
    }
    // MARK: Add Button Action--
    ///Create action for Add  cell in tableView
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func addCellActionButton(_ sender: UIButton) {
//                if createdTicketList.count < 2{
//                    createdTicketList.append(CreateTicket(indexCount: 1))
//                }
//                tableViewHeight.constant = CGFloat(320*createdTicketList.count)
//                tikcetTableView.reloadData()
   }
    
    
}
// MARK: Create extension for Tableview delegate method--
extension CreateTicketViewController: UITableViewDelegate,UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return CreateTicketViewController.createdTicketList.count
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = tableView.dequeueReusableCell(withIdentifier: CreateTicketTableViewCell.identifier, for: indexPath) as? CreateTicketTableViewCell else {return UITableViewCell()}
        if indexPath.row == 1 {
            cell.minusButton.isHidden = false
        }
        else{
            cell.minusButton.isHidden = true
        }
        cell.indexPath = indexPath.row
        cell.createTicketVC = self
        cell.minusButton.tag = indexPath.row
        cell.minusButton.addTarget(self, action: #selector(deleteActionButton(sender: )), for: .touchUpInside)
        return cell
    }
}
// MARK: create extension for Textfield delegate--
///fucntion for textfiled validation not typed in dropdown textfield
extension CreateTicketViewController: UITextFieldDelegate{
    func textFieldShouldBeginEditing(_ textField: UITextField) -> Bool
    {
        switch textField {
        case dropDownTextField:
            return false
        default:
            return true
        }
    }
}
// MARK: create stucture for access cell textfield--
struct CreateTicket {
    var ticketTitle: String?
    var ticketQty: String?
    var ticketPrice: Double?
    var ticketType:String?
    var endDate: String?
    var endTime: String?
    var indexCount: Int?
    
}
