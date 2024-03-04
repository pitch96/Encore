//
//  ManageEventViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 05/01/23.
//

import UIKit

class ManageEventViewController: UIViewController {
    // MARK: IBOutlets
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var eventSelection: UISegmentedControl!
    @IBOutlet weak var manageEventTableView: UITableView!
    @IBOutlet weak var lblNoRecord: UILabel!
    
    // MARK: Variable Initializer
    var manageEventViewModel = ManageEventViewModel()
    var manageEventData: [ManageEventModelDetail]?
    var searchEventData: [ManageEventModelDetail]?
    var data : [GetAllData]?
    var sData : [GetAllData]?
    var segmentIndex = 0
    
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        manageEventTableView.delegate = self
        manageEventTableView.dataSource = self
        searchTextField.delegate = self
        // Do any additional setup after loading the view.
        
        manageEventTableView.reloadData()
    }
    // MARK: - viewWillAppear
    override func viewWillAppear(_ animated: Bool) {
        searchTextField.text = ""
        manageEventApi()
        getAllEventApi()
    }
    
    // MARK: - Create function for calling Get All Event API
    func getAllEventApi(){
        manageEventViewModel.calllAllEventApi {[weak self] allEventData, isSuccess in
            if isSuccess == true{
                self?.data = allEventData.data
                self?.sData = allEventData.data
                self?.manageEventTableView.reloadData()
            }else{
                self?.showSimpleAlert(message: allEventData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Create function for calling get event api
    func manageEventApi(){
        manageEventViewModel.calllManageEventApi {[weak self] manageEventDetails, isSuccess in
            if isSuccess == true{
                if manageEventDetails.data?.count == 0{
                    self?.lblNoRecord.isHidden = false
                    self?.manageEventTableView.reloadData()
                }else{
                    self?.lblNoRecord.isHidden = true
                    self?.manageEventData = manageEventDetails.data
                    self?.searchEventData = manageEventDetails.data
                    self?.manageEventTableView.reloadData()
                }
            }else{
                self?.showSimpleAlert(message: manageEventDetails.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - View Button Action
    ///Create function for view event Details
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapEye(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: EventDetailViewController.identifier) as! EventDetailViewController
        vc.selectedSegment = segmentIndex
        if segmentIndex == 0{
            vc.eventdetailsViewModel.id = searchEventData?[sender.tag].id ?? 0
        }else{
            vc.eventdetailsViewModel.id = sData?[sender.tag].id ?? 0
        }
        
        self.navigationController?.pushViewController(vc , animated: true)
    }
    // MARK: - Edit Button Action
    ///Create function for navigate to update event Screen
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapEditBtn(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: UpdateEventViewController.identifier) as! UpdateEventViewController
        if segmentIndex == 0{
            vc.updateEventViewModel.id = searchEventData?[sender.tag].id ?? 0
        }else{
            vc.updateEventViewModel.id = sData?[sender.tag].id ?? 0
        }
        self.navigationController?.pushViewController(vc , animated: true)
    }
    // MARK: - Delete Button Action
    ///Create function for delete event
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapDeleteBtn(sender: UIButton){
        if segmentIndex == 0{
            let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeleteEvent, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
                self.manageEventViewModel.callDeleteEventApi(id: self.searchEventData?[sender.tag].id ?? 0) {[weak self] deleteEventData, isSuccess in
                    if isSuccess == true{
                        self?.showSimpleAlert(message: deleteEventData?.message ?? DefaultValue.errorMsg.rawValue)
                        self?.manageEventApi()
                        self?.getAllEventApi()
                        self?.manageEventTableView.reloadData()
                        
                    }else{
                        self?.showSimpleAlert(message: deleteEventData?.message ?? DefaultValue.errorMsg.rawValue)
                    }
                    
                }}))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
            self.present(alert, animated: true, completion: nil)
        }else{
            let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.DeleteEvent, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler:{ action in
                self.manageEventViewModel.callDeleteEventApi(id: self.sData?[sender.tag].id ?? 0) {[weak self] deleteEventData, isSuccess in
                    if isSuccess == true{
                        self?.showSimpleAlert(message: deleteEventData?.message ?? DefaultValue.errorMsg.rawValue)
                        self?.manageEventApi()
                        self?.getAllEventApi()
                        self?.manageEventTableView.reloadData()
                        
                    }else{
                        self?.showSimpleAlert(message: deleteEventData?.message ?? DefaultValue.errorMsg.rawValue)
                    }
                    
                }}))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
            self.present(alert, animated: true, completion: nil)
        }
        
    }
    // MARK: - Create function for select event
    /// create function for selecting my event and all event
    /// - Parameter sender: UISegmentedControl
    /// - Return : nil
    @IBAction func eventSelectionButtonAction(_ sender: UISegmentedControl) {
        let selection = sender.selectedSegmentIndex
        segmentIndex = sender.selectedSegmentIndex
        switch selection {
        case 0:
            searchTextField.text = ""
            manageEventTableView.reloadData()
            manageEventApi()
            
        case 1:
            searchTextField.text = ""
            manageEventTableView.reloadData()
            getAllEventApi()
        default:
            break
        }
    }
    // MARK: - Back Button Action
    ///- Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
// MARK: - Create extention for caliing tableview delegate and dataSource
extension ManageEventViewController: UITableViewDelegate, UITableViewDataSource {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        lblNoRecord.isHidden = (segmentIndex == 0) ? ((searchEventData?.count ?? 0 > 0) ? true : false) : ((sData?.count ?? 0 > 0) ? true : false)
        return (segmentIndex == 0) ? searchEventData?.count ?? 0 : sData?.count ?? 0
        
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: ManageEventTableViewCell.identifier) as! ManageEventTableViewCell
        cell.HideIsPopularForPromoter()
        // MARK: show edit delete button for admin and promoter
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        switch userType {
        case 1:
            
            if segmentIndex == 0{
                let data = searchEventData?[indexPath.row]
                cell.titleLabel.text = data?.eventTitle?.capitalized
                cell.categoryType.text = data?.organizer
                //  cell.showEventApprovalStatus(status: data?.promoterRequestResponse?.status)
                cell.eventStatusLabel.text = "StartDate:- \(data?.startDate ?? DefaultValue.emptyString.rawValue)" + " " + (data?.startTime ?? DefaultValue.emptyString.rawValue)
                cell.lblEventStatus.text = "Event Status:- \(data?.eventStatus ?? DefaultValue.emptyString.rawValue)"
                cell.editButton.tag = indexPath.row
                cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
                cell.deleteButton.tag = indexPath.row
                cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
                cell.eyeButton.tag = indexPath.row
                cell.eyeButton.addTarget(self, action: #selector(tapEye(sender: )), for: .touchUpInside)
                cell.createdByLabel.text = data?.venue
                switch data?.promoterRequestResponse?.status {
                case 0:
                    cell.lblApproval.text = DefaultValue.InProgress.rawValue
                    cell.lblApproval.backgroundColor = UIColor.yellow
                    cell.lblApproval.textColor = UIColor.black
                case 1:
                    cell.lblApproval.text = DefaultValue.Approved.rawValue
                    cell.lblApproval.backgroundColor = UIColor.green
                    cell.lblApproval.textColor = UIColor.black
                case 2:
                    cell.lblApproval.text = DefaultValue.Rejected.rawValue
                    cell.lblApproval.backgroundColor = UIColor.red
                    cell.lblApproval.textColor = UIColor.black
                default:
                    cell.lblApproval.text = "Pay $\(data?.paybleAmount ?? 0)"
                    cell.lblApproval.backgroundColor = UIColor.cyan
                    cell.lblApproval.textColor = UIColor.black
                }
                cell.showEventStatus(status: data?.status ?? 0)
                cell.isLive.tag = indexPath.row
                cell.isLive.addTarget(self, action: #selector(self.myEventStatusChanged(_:)), for: .valueChanged)
                if data?.status == 1 {
                    cell.changePopularStatus(isPopular: (data?.isPopular ?? 0) ?? 0)
                } else {
                    cell.changePopularStatus(isPopular: 0)
                }
                cell.changePopularStatus(isPopular: (data?.isPopular ?? 0) ?? 0)
                cell.popularEventStatus.tag = indexPath.row
                cell.popularEventStatus.addTarget(self, action: #selector(self.popularAllEventStatusChanged(_:)), for: .valueChanged)
                
            } else {
                let data = sData?[indexPath.row]
                cell.titleLabel.text = data?.eventTitle?.capitalized
                cell.categoryType.text = data?.organizer
                //               cell.showEventApprovalStatus(status: data?.promoterRequestResponse?.status)
                cell.eventStatusLabel.text = "StartDate:- \(data?.startDate ?? DefaultValue.emptyString.rawValue)" + " " + (data?.startTime ?? DefaultValue.emptyString.rawValue)
                cell.lblEventStatus.text = "Event Status:-  \(data?.eventStatus ?? DefaultValue.emptyString.rawValue)"
                cell.editButton.tag = indexPath.row
                cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
                cell.deleteButton.tag = indexPath.row
                cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
                cell.eyeButton.tag = indexPath.row
                cell.eyeButton.addTarget(self, action: #selector(tapEye(sender: )), for: .touchUpInside)
                cell.createdByLabel.text = data?.venue
                switch data?.promoterRequestResponse?.status {
                case 0:
                    cell.lblApproval.text = DefaultValue.InProgress.rawValue
                    cell.lblApproval.backgroundColor = UIColor.yellow
                    cell.lblApproval.textColor = UIColor.black
                case 1:
                    cell.lblApproval.text = DefaultValue.Approved.rawValue
                    cell.lblApproval.backgroundColor = UIColor.green
                    cell.lblApproval.textColor = UIColor.black
                case 2:
                    cell.lblApproval.text = DefaultValue.Rejected.rawValue
                    cell.lblApproval.backgroundColor = UIColor.red
                    cell.lblApproval.textColor = UIColor.black
                default:
                    //cell.lblApproval.text = DefaultValue.Approved.rawValue
                    cell.lblApproval.text = "Pay $\(data?.paybleAmount ?? 0)"
                    cell.lblApproval.backgroundColor = UIColor.cyan
                    cell.lblApproval.textColor = UIColor.black
                }
                cell.showEventStatus(status: data?.status ?? 0)
                cell.isLive.addTarget(self, action: #selector(self.myEventStatusChanged(_:)), for: .valueChanged)
                cell.isLive.tag = indexPath.row
                cell.changePopularStatus(isPopular: data?.isPopular ?? 0)
                cell.popularEventStatus.tag = indexPath.row
                cell.popularEventStatus.addTarget(self, action: #selector(self.popularAllEventStatusChanged(_:)), for: .valueChanged)
            }
        case 3:
            cell.isLive.addTarget(self, action: #selector(self.myEventStatusChanged(_:)), for: .valueChanged)
            cell.isLive.addTarget(self, action: #selector(self.allEventStatusChanged(_:)), for: .valueChanged)
            if segmentIndex == 0{
                let data = searchEventData?[indexPath.row]
                cell.titleLabel.text = data?.eventTitle?.capitalized
                cell.categoryType.text = data?.organizer
                //                cell.showEventApprovalStatus(status: data?.promoterRequestResponse?.status)
                cell.eventStatusLabel.text = "StartDate:- \(data?.startDate ?? DefaultValue.emptyString.rawValue)" + " " + (data?.startTime ?? DefaultValue.emptyString.rawValue)
                cell.lblEventStatus.text = "Event Status:- \(data?.eventStatus ?? DefaultValue.emptyString.rawValue)"
                cell.editButton.tag = indexPath.row
                cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
                cell.deleteButton.tag = indexPath.row
                cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
                cell.eyeButton.tag = indexPath.row
                cell.eyeButton.addTarget(self, action: #selector(tapEye(sender: )), for: .touchUpInside)
                cell.createdByLabel.text = data?.venue
                switch data?.promoterRequestResponse?.status {
                case 0:
                    cell.lblApproval.text = DefaultValue.InProgress.rawValue
                    cell.lblApproval.backgroundColor = UIColor.yellow
                    cell.lblApproval.textColor = UIColor.black
                case 1:
                    cell.lblApproval.text = DefaultValue.Approved.rawValue
                    cell.lblApproval.backgroundColor = UIColor.green
                    cell.lblApproval.textColor = UIColor.black
                case 2:
                    cell.lblApproval.text = DefaultValue.Rejected.rawValue
                    cell.lblApproval.backgroundColor = UIColor.red
                    cell.lblApproval.textColor = UIColor.black
                default:
                    cell.lblApproval.text = "Pay $\(data?.paybleAmount ?? 0)"
                    cell.lblApproval.backgroundColor = UIColor.cyan
                    cell.lblApproval.textColor = UIColor.black
                }
                
                cell.showEventStatus(status: data?.status ?? 0)
                cell.isLive.tag = indexPath.row
                
                cell.editButton.isHidden = false
                cell.deleteButton.isHidden = false
            } else {
                cell.editButton.isHidden = true
                cell.deleteButton.isHidden = true
                let data = sData?[indexPath.row]
                cell.titleLabel.text = data?.eventTitle?.capitalized
                cell.categoryType.text = data?.organizer
                //  cell.showEventApprovalStatus(status: data?.promoterRequestResponse?.status)
                cell.eventStatusLabel.text = "StartDate:- \(data?.startDate ?? DefaultValue.emptyString.rawValue)" + " " + (data?.startTime ?? DefaultValue.emptyString.rawValue)
                cell.lblEventStatus.text = "Event Status:-  \(data?.eventStatus ?? DefaultValue.emptyString.rawValue)"
                cell.editButton.tag = indexPath.row
                cell.editButton.addTarget(self, action: #selector(tapEditBtn(sender: )), for: .touchUpInside)
                cell.deleteButton.tag = indexPath.row
                cell.deleteButton.addTarget(self, action: #selector(tapDeleteBtn(sender: )), for: .touchUpInside)
                cell.eyeButton.tag = indexPath.row
                cell.eyeButton.addTarget(self, action: #selector(tapEye(sender: )), for: .touchUpInside)
                cell.createdByLabel.text = data?.venue
                
                switch data?.promoterRequestResponse?.status {
                case 0:
                    cell.lblApproval.text = DefaultValue.InProgress.rawValue
                    cell.lblApproval.backgroundColor = UIColor.yellow
                    cell.lblApproval.textColor = UIColor.black
                case 1:
                    cell.lblApproval.text = DefaultValue.Approved.rawValue
                    cell.lblApproval.backgroundColor = UIColor.green
                    cell.lblApproval.textColor = UIColor.black
                case 2:
                    cell.lblApproval.text = DefaultValue.Rejected.rawValue
                    cell.lblApproval.backgroundColor = UIColor.red
                    cell.lblApproval.textColor = UIColor.black
                default:
                    cell.lblApproval.text = DefaultValue.Approved.rawValue
                    //cell.lblApproval.text = "Pay $\(data?.paybleAmount ?? 0)"
                    cell.lblApproval.backgroundColor = UIColor.green
                    cell.lblApproval.textColor = UIColor.black
                }
                cell.showEventStatus(status: data?.status ?? 0)
                cell.isLive.tag = indexPath.row
              
            }
        default:
            break
        }
        return cell
    }
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: BookedEventTicketViewController.identifier)as! BookedEventTicketViewController
        if segmentIndex == 0{
            vc.bookedEventDetailsViewModel.id = searchEventData?[indexPath.row].id ?? 0
            vc.bookedEventDetailsViewModel.image = searchEventData?[indexPath.row].image ?? DefaultValue.emptyString.rawValue
        }else{
            vc.bookedEventDetailsViewModel.id = sData?[indexPath.row].id ?? 0
            vc.bookedEventDetailsViewModel.image = sData?[indexPath.row].image ?? DefaultValue.emptyString.rawValue
        }
        self.navigationController?.pushViewController(vc, animated: true)
        debugPrint(DefaultValue.emptyString.rawValue)
        self.manageEventTableView.reloadData()
    }
    // MARK: - Create action For change Popular event Status of MYEvent
    ////// - Parameter sender: UIButton
    /// return : nil
//    @objc func popularEventStatusChanged(_ sender : UISwitch!) {
//        popularEventByAdmin(index:sender.tag)
//    }
 
    // MARK: - Create Alert for admin Rejected the event by Admin
    func RejectedByAdmin(){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.RejectedEvent, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
    }
    // MARK: - Create function for approval to admin
    func alertforApproval(){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.AdminResponce, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
    }
    
    
    
    // MARK: - Create function for takes approval from Admin
    func sendRequestForApproval(index:Int){
        if manageEventData?[index].eventStatus == DefaultValue.Expired.rawValue{
            let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.ExpiredEvent, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            self.present(alert, animated: true, completion: nil)
        }else{
            let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.TakeApproval, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: AppMessage.shared.GetAccess, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                let vc = self.storyboard?.instantiateViewController(withIdentifier: PromoterPaymentViewController.identifier) as! PromoterPaymentViewController
                vc.eventID = self.manageEventData?[index].id ?? 0
                vc.Ammount = self.manageEventData?[index].paybleAmount ?? 0
                self.navigationController?.pushViewController(vc, animated: true)
            }))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            self.present(alert, animated: true, completion: nil)
        }
    }
    
    
    // MARK: - Create function for change status of Popular Myevents
//    func popularEventByAdmin(index: Int){
//        let eventID = searchEventData?[index].id ?? 0
//        let preStatus = searchEventData?[index].isPopular ?? 0
//        var msg = ""
//        var toLiveStatus = 0
//        switch preStatus {
//        case 0:
//            msg = AppMessage.shared.MakePopularEvent
//            toLiveStatus = 1
//        case 1:
//            msg = AppMessage.shared.RemovePopularEvent
//            toLiveStatus = 0
//        default:
//            break
//        }
//        let alert = UIAlertController(title: Alert.projectName, message: msg, preferredStyle: UIAlertController.Style.alert)
//        alert.addAction(UIAlertAction(title: Alert.changeStatus, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
//            self.changePopularStatusApi(eventID: eventID, status: toLiveStatus)
//
//        }))
//        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
//            self.manageEventTableView.reloadData()
//        }))
//        self.present(alert, animated: true, completion: nil)
//    }
//
    
    
    // MARK: - Create function for calling popular event status change API
    func changePopularStatusApi(eventID:Int, status:Int) {
        manageEventViewModel.callPopularEventApi(eventId: eventID, status: status) {[weak self] popularData, isSuccess in
            if isSuccess == true {
                let refreshAlert = UIAlertController(title: Alert.projectName, message: popularData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
                self?.manageEventApi()
                self?.showSimpleAlert(message: popularData?.message ?? DefaultValue.emptyString.rawValue)
            }else{
                self?.showSimpleAlert(message: popularData?.message ?? DefaultValue.emptyString.rawValue)
                self?.manageEventTableView.reloadData()
            }
        }
    }
    
    // MARK: Create function for Change Status of my event using Switch
    func changeStatusMyEvent(eventID:Int, status:Int){
        manageEventViewModel.callGetStatusApi(eventId: eventID, status: status) { [weak self] data, isSucess in
            if isSucess{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: data?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
                self?.manageEventApi()
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.emptyString.rawValue)
            }else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.emptyString.rawValue)
                self?.manageEventTableView.reloadData()
            }
        }
    }
    
    // MARK: - Create function for ALL event Approval From Admin
    func sendAllEventRequestForApproval(index:Int){
        if segmentIndex == 0 {
            if manageEventData?[index].eventStatus == DefaultValue.Expired.rawValue{
                let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.ExpiredEvent, preferredStyle: UIAlertController.Style.alert)
                alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    self.manageEventTableView.reloadData()
                }))
                alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    self.manageEventTableView.reloadData()
                }))
                self.present(alert, animated: true, completion: nil)
            }else{
                let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.TakeApproval, preferredStyle: UIAlertController.Style.alert)
                alert.addAction(UIAlertAction(title: AppMessage.shared.GetAccess, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    let vc = self.storyboard?.instantiateViewController(withIdentifier: PromoterPaymentViewController.identifier) as! PromoterPaymentViewController
                    vc.eventID = self.data?[index].id ?? 0
                    vc.Ammount = self.data?[index].paybleAmount ?? 0
                    self.navigationController?.pushViewController(vc, animated: true)
                }))
                alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    self.manageEventTableView.reloadData()
                }))
                self.present(alert, animated: true, completion: nil)
            }
        }else {
            if searchEventData?[index].eventStatus == DefaultValue.Expired.rawValue{
                let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.ExpiredEvent, preferredStyle: UIAlertController.Style.alert)
                alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    self.manageEventTableView.reloadData()
                }))
                alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    self.manageEventTableView.reloadData()
                }))
                self.present(alert, animated: true, completion: nil)
            }else{
                let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.TakeApproval, preferredStyle: UIAlertController.Style.alert)
                alert.addAction(UIAlertAction(title: AppMessage.shared.GetAccess, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    let vc = self.storyboard?.instantiateViewController(withIdentifier: PromoterPaymentViewController.identifier) as! PromoterPaymentViewController
                    vc.eventID = self.sData?[index].id ?? 0
                    vc.Ammount = self.sData?[index].paybleAmount ?? 0
                    self.navigationController?.pushViewController(vc, animated: true)
                }))
                alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                    self.manageEventTableView.reloadData()
                }))
                self.present(alert, animated: true, completion: nil)
            }
        }
    }
    // MARK: - Create function for popular Event for All
    @objc func popularAllEventStatusChanged(_ sender : UISwitch!) {
        popularAllEventByAdmin(index: sender.tag)
    }
    // MARK: - Create function for calling popular event status change API
    func changePopularAllStatusApi(eventID:Int, status:Int) {
        manageEventViewModel.callPopularEventApi(eventId: eventID, status: status) { [weak self]data, isSucess in
            if isSucess{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.emptyString.rawValue)
                self?.manageEventApi()
                self?.getAllEventApi()
            }else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.emptyString.rawValue)
            }
        }
    }
    // MARK: - Create alert for valid promoter
    func authenticatePromoter(){
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.ActionError, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
    }
    // MARK: - create function for change status of All event
    func changeStatusAllEvent(eventID:Int, status:Int){
        manageEventViewModel.callGetStatusApi(eventId: eventID, status: status) { [weak self]data, isSucess in
            if isSucess{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.emptyString.rawValue)
                //self?.manageEventApi()
                self?.getAllEventApi()
            }else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.emptyString.rawValue)
                
            }
        }}
}
// MARK: - Create a function for search event by name in textfield
///create function for searching event
extension ManageEventViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if segmentIndex == 0{
            if let searchedText = searchTextField.text,
               let textRange = Range(range, in: searchedText){
                
                let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
                if updatedText != ""{
                    searchEventData = manageEventData?.filter({ values in
                        return (values.organizer ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.venue ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                    })
                }else{
                    searchEventData = manageEventData
                }
                manageEventTableView.reloadData()
            }
            return true
        }else{
            if let searchedText = searchTextField.text,
               let textRange = Range(range, in: searchedText){
                
                let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
                if updatedText != ""{
                    sData = data?.filter({ values in
                        return (values.organizer ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.venue ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                    })
                }else{
                    sData = data
                }
                manageEventTableView.reloadData()
            }
            return true
        }
    }
    // MARK: - Create funtion for return value on return key
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}

// MARK: - Create extension for popular event
extension ManageEventViewController {
    
    // MARK: - status changed for popular All Event
    func popularAllEventByAdmin(index: Int) {
        switch segmentIndex{
        case 0:
            if searchEventData?[index].status ?? 0 == 1 {
                makeEventPopular(index:index)
            } else {
                showAlertForPoularEventError()
                
            }
        case 1:
            if sData?[index].status ?? 0 == 1 {
                makeEventPopular(index:index)
            } else {
                
                showAlertForPoularEventError()
            }
        default: break
        }
    }
    // MARK: - Create function for change popular status
    func makeEventPopular(index:Int){
        var eventID : Int?
        var preStatus:Int?
        switch segmentIndex{
        case 0:
            eventID = searchEventData?[index].id ?? 0
            preStatus = searchEventData?[index].isPopular ?? 0
        case 1:
            eventID = sData?[index].id ?? 0
            preStatus = sData?[index].isPopular ?? 0
            
        default: break
        }
        var msg = ""
        var toLiveStatus = 0
        switch preStatus {
        case 0:
            msg = AppMessage.shared.MakePopularEvent
            toLiveStatus = 1
        case 1:
            msg = AppMessage.shared.RemovePopularEvent
            toLiveStatus = 0
        default:
            break
        }
        let alert = UIAlertController(title: Alert.projectName, message: msg, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.changeStatus, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.changePopularAllStatusApi(eventID: eventID ?? 0, status: toLiveStatus)
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
        
    }
    // MARK: - Create function for showing alert
    func showAlertForPoularEventError(){
        let msg = AppMessage.shared.FirstLiveEvent
        
        let alert = UIAlertController(title: Alert.projectName, message: msg, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
            self.manageEventTableView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
        
    }
}

// MARK: - Extention for my event status
extension ManageEventViewController {
    // MARK: - Create action For change Status of MyEvent
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func myEventStatusChanged(_ sender : UISwitch!) {
        switch segmentIndex{
        case 0:
            myEventStatusChanged(sender : sender)
        case 1:
            allEventStatusChanged(sender : sender)
            
        default: break
        }
        
    }
    // MARK: - Create function for change status of My Event
    func myEventStatusChanged(sender : UISwitch!){
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        switch userType{
            // MARK: Admin
        case 1:
            // MARK: - Live Event Without permission
            liveEventByAdminAndPromoter(index:sender.tag)
            // MARK: - Promoter takes Approval from admin
        case 3:
            
            if(manageEventData?[sender.tag].verifiedPromoterEvent == 1 && manageEventData?[sender.tag].promoterRequestResponse?.status == 0) {
                //self.showSimpleAlert(message: "Wait for Admin's response for this event")
                alertforApproval()
            }
            else if (manageEventData?[sender.tag].verifiedPromoterEvent == 1 && manageEventData?[sender.tag].promoterRequestResponse?.status == 1){
                liveEventByAdminAndPromoter(index:sender.tag)
            }
            else if (manageEventData?[sender.tag].verifiedPromoterEvent == 1 && manageEventData?[sender.tag].promoterRequestResponse?.status == 2){
                RejectedByAdmin()
            } else if self.manageEventData?[sender.tag].promoterRequestResponse == nil {
                sendRequestForApproval(index:sender.tag)
            }
            else if  self.manageEventData?[sender.tag].promoterRequestResponse?.status ?? 0 == 0 {
                alertforApproval()
            }
            else if self.manageEventData?[sender.tag].promoterRequestResponse?.status ?? 0 == 1{
                // MARK: - functionality to live
                liveEventByAdminAndPromoter(index:sender.tag)
                
            }
            else if self.manageEventData?[sender.tag].promoterRequestResponse?.status ?? 0 == 2{
                // MARK: - functionality to Rejected
                RejectedByAdmin()
            }
        default:
            break
        }
    }
    // MARK: - Create function for change event status of All Event
    func allEventStatusChanged(sender : UISwitch!){
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        switch userType{
            // MARK: Admin
        case 1:
            // MARK: - Live Event Without permission
            liveAllEventByAdminAndPromoter(index:sender.tag)
            //liveEventByAdminAndPromoter(index: sender.tag)
            // MARK: Promoter takes Approval from admin-
        case 3:
            // MARK: - Pending
            if data?[sender.tag].userID == sData?[sender.tag].id {
                //liveEventByAdminAndPromoter(index: sender.tag)
                liveAllEventByAdminAndPromoter(index:sender.tag)
            }else {
                authenticatePromoter()
            }
        default:
            break
        }
        
    }
    
    // MARK: Create Action for change status of all event
    ///- Parameter sender: UIButton
    /// return : nil
    @objc func allEventStatusChanged(_ sender : UISwitch!){
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        switch userType{
            // MARK: Admin
        case 1:
            // MARK: - Live Event Without permission
            // liveAllEventByAdminAndPromoter(index:sender.tag)
            liveEventByAdminAndPromoter(index: sender.tag)
            // MARK: Promoter takes Approval from admin-
        case 3:
            // MARK: - Pending
            if data?[sender.tag].userID == sData?[sender.tag].id {
                liveEventByAdminAndPromoter(index: sender.tag)
                // liveAllEventByAdminAndPromoter(index:sender.tag)
            }else {
                authenticatePromoter()
            }
        default:
            break
        }
    }
    
    // MARK: - Create function for live event
    func liveEventByAdminAndPromoter(index:Int){
        if manageEventData?[index].eventStatus == DefaultValue.Expired.rawValue {
            let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.ExpiredEvent, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            self.present(alert, animated: true, completion: nil)
        }else{
            print("MyEvent:- \(index)")
            var eventID : Int?
            var preStatus:Int?
            switch segmentIndex{
            case 0:
                eventID = searchEventData?[index].id ?? 0
                preStatus = searchEventData?[index].status ?? 0
            case 1:
                eventID = sData?[index].id ?? 0
                preStatus = sData?[index].status ?? 0
                
            default: break
            }
            var message = ""
            var toLiveStatus = 0
            switch preStatus {
            case 0:
                message = AppMessage.shared.LiveEvent
                toLiveStatus = 1
            case 1:
                message = AppMessage.shared.RemoveLiveEvent
                toLiveStatus = 0
            default:
                break
            }
            let alert = UIAlertController(title: Alert.projectName, message: message, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                
                switch self.segmentIndex{
                case 0:
                    self.changeStatusMyEvent(eventID: eventID ?? 0, status: toLiveStatus)
                case 1:
                    self.changeStatusAllEvent(eventID: eventID ?? 0, status: toLiveStatus)
                    
                default: break
                }
            }))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            self.present(alert, animated: true, completion: nil)
        }
    }
    
    // MARK: - Create function for change status for all event if event is Expired or not
    func liveAllEventByAdminAndPromoter(index:Int){
        if data?[index].eventStatus == DefaultValue.Expired.rawValue {
            let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.ExpiredEvent, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            self.present(alert, animated: true, completion: nil)
        }else{
            debugPrint("AllEvent:- \(index)")
            let eventID = sData?[index].id ?? 0
            let preStatus = sData?[index].status ?? 0
            var message = ""
            var toLiveStatus = 0
            switch preStatus {
            case 0:
                message = AppMessage.shared.LiveEvent
                toLiveStatus = 1
            case 1:
                message = AppMessage.shared.RemoveLiveEvent
                toLiveStatus = 0
            default:
                break
            }
            let alert = UIAlertController(title: Alert.projectName, message: message, preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action:UIAlertAction!) in
                self.changeStatusAllEvent(eventID: eventID, status: toLiveStatus)
            }))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: {(action: UIAlertAction!) in
                self.manageEventTableView.reloadData()
            }))
            
            self.present(alert, animated: true, completion: nil)
        }
    }
   
}
 
