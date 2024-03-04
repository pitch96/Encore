//
//  EventOrderViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/04/23.
//

import UIKit

class EventOrderViewController: UIViewController {
// MARK: IBOutlets--
    @IBOutlet weak var tableviewEventOrder: UITableView!
    @IBOutlet weak var selectEvent: UISegmentedControl!
    @IBOutlet weak var lblNoRecord: UILabel!
    @IBOutlet weak var searchTextField: UITextField!
    // MARK: Variable Initializer--
    var  eventOrderModel = EventOrderModel()
    lazy var eventOrderViewModel:EventOrderViewModel = {
        var eventOrderViewModel = EventOrderViewModel()
        return eventOrderViewModel
    }()
    var manageOrderData: [EventOrderData]?
    var searchOrderData: [EventOrderData]?
    var dData: [RunningeEventDetail]?
    var sData: [RunningeEventDetail]?
    var segmentIndex = 0
    
    // MARK: - viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        tableviewEventOrder.delegate = self
        tableviewEventOrder.dataSource = self
        searchTextField.delegate = self
        if segmentIndex == 0{
            callRunningApi()
        }else{
            callEventExpiredApi()
        }
        tableviewEventOrder.reloadData()
    }
   
    // MARK: Create function for calling Running event API--
    func callRunningApi(){
        eventOrderViewModel.callRunningEventApi {[weak self] runningData, isSuccess in
            if isSuccess == true{
                    self?.dData = runningData.data
                    self?.sData = runningData.data
                    self?.tableviewEventOrder.reloadData()
            }else{
               // self?.showSimpleAlert(message: runningData.message ?? DefaultValue.emptyString.rawValue)
            }
        }
    }
    
    // MARK: Create function for calling get order detail API--
    func callEventExpiredApi(){
        eventOrderViewModel.callExpiredEventApi {[weak self] expireData, isSuccess in
            if isSuccess == true {
                self?.manageOrderData = expireData.data
                self?.searchOrderData = expireData.data
                self?.tableviewEventOrder.reloadData()
            } else {
               // self?.showSimpleAlert(message: expireData.message ?? DefaultValue.emptyString.rawValue)
            }
        }
    }
    // MARK: - Create function for select event
    /// create function for selecting Expired event and Running event
    /// - Parameter sender: - UISegmentedControl
    /// - Return : nil
    @IBAction func eventSelectionButtonAction(_ sender: UISegmentedControl) {
        let selection = sender.selectedSegmentIndex
        segmentIndex = sender.selectedSegmentIndex
        switch selection {
        case 0:
            searchTextField.text = ""
            tableviewEventOrder.reloadData()
            callRunningApi()
                     
        case 1:
            searchTextField.text = ""
            tableviewEventOrder.reloadData()
            callEventExpiredApi()
        default:
            break
        }
    }
    // MARK: Back Button Action--
    /// create function for navigate to previous screen
    /// - Parameter sender: UIButton
    /// - Return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: See Order Button Action--
    /// create function for navigate to GuestList Screen
    /// - Parameter sender: UIButton
    /// - Return : nil
    @objc func pressedSeeOrder(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: GuestListViewController.identifier) as! GuestListViewController
        if segmentIndex == 0{
            vc.Id = sData?[sender.tag].id ?? 0
            vc.runningOrder = sData?[sender.tag].order
        }else {
            vc.Id = searchOrderData?[sender.tag].id ?? 0
            vc.expiredOrder = searchOrderData?[sender.tag].order
        }
        self.navigationController?.pushViewController(vc, animated: true)
        
    }
}

// MARK: Create extension for tableview delegate and datasource--
extension EventOrderViewController: UITableViewDelegate, UITableViewDataSource {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        lblNoRecord.isHidden =  (segmentIndex == 0) ? ((sData?.count ?? 0 > 0) ? true : false) : ((searchOrderData?.count ?? 0 > 0) ? true : false)
        return (segmentIndex == 0) ? sData?.count ?? 0 : searchOrderData?.count ?? 0
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: EventOrderTableViewCell.identifier, for: indexPath) as! EventOrderTableViewCell
        
        if segmentIndex == 0{
            let data = sData?[indexPath.row]
            cell.lblTitleEvent.text = "Event Title:- \(data?.eventTitle ?? DefaultValue.emptyString.rawValue)".capitalized
            cell.lblAmount.text = "Revenue generated:- $\(data?.revenue?.revenueGenerated ?? 0)"
            let ticketCount = data?.ticketsSold?.ticketsSold
            cell.lblTicketSold.text = "Ticket Sold:- \((ticketCount != nil ? ticketCount : "0") ?? DefaultValue.emptyString.rawValue)"
            cell.lblstartDateTime.text = "StartDate/Time:- \(data?.startDate ?? DefaultValue.emptyString.rawValue)" + " " + (data?.startTime ?? DefaultValue.emptyString.rawValue)
            cell.lblGuestCount.text = "Guest Count:- \(data?.guestCount ?? 0)"
            
        }else{
            let data = searchOrderData?[indexPath.row]
            cell.lblTitleEvent.text = "Event Title:- \(data?.eventTitle ?? DefaultValue.emptyString.rawValue)".capitalized
            cell.lblAmount.text = "Revenue generated:- $\(data?.revenue?.revenueGenerated ?? 0)"
            let ticketCount = data?.ticketsSold?.ticketsSold
            cell.lblTicketSold.text = "Ticket Sold:- \((ticketCount != nil ? ticketCount : "0") ?? DefaultValue.emptyString.rawValue)"
            cell.lblstartDateTime.text = "StartDate/Time:- \(data?.endDate ?? DefaultValue.emptyString.rawValue)" + " " + (data?.endTime ?? DefaultValue.emptyString.rawValue)
            cell.lblGuestCount.text = "Guest Count:- \(data?.guestCount ?? 0)"
            
        }
        cell.seeeOrderButton.tag = indexPath.row
        cell.seeeOrderButton.addTarget(self, action: #selector(pressedSeeOrder(sender: )), for: .touchUpInside)
        return cell
    }

}
// MARK: Create a function for search event by name in textfield--
///create function for searching event
extension EventOrderViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if segmentIndex == 0 {
                if updatedText != "" {
                    sData = dData?.filter({ values in
                        return (values.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || "\(values.revenue?.revenueGenerated ?? 0)".lowercased().contains(updatedText.lowercased()) || (values.ticketsSold?.ticketsSold ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                        
                    })
                }else{
                    sData = dData
                }
            } else {
                if updatedText != "" {
                    searchOrderData = manageOrderData?.filter({ values in
                        return (values.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || "\(values.revenue?.revenueGenerated ?? 0)".lowercased().contains(updatedText.lowercased()) || (values.ticketsSold?.ticketsSold ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                        
                    })
                }else{
                    searchOrderData = manageOrderData
                }
            }
            tableviewEventOrder.reloadData()
        }
        return true
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
