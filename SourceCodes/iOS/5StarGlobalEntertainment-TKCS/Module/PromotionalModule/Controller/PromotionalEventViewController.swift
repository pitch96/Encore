//
//  PromotionalEventViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 12/04/23.
//

import UIKit

class PromotionalEventViewController: UIViewController {
   // MARK: - IBOutlets
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var tableviewPromotionalEvent: UITableView!
    @IBOutlet weak var selectEventSegment: UISegmentedControl!
    @IBOutlet weak var lblNorecordFound: UILabel!
    // MARK: - Variable initializer
    var promotionalModel = PromotionalModel()
    lazy var promotionalViewModel:PromotionalViewModel = {
        var promotionalViewModel = PromotionalViewModel()
        return promotionalViewModel
    }()
    var managePromotionalData: [PromotionalDetails]?
    var searchPromotionalData: [PromotionalDetails]?
    var manageFreeEventData : [FreeEventModelDetails]?
    var searchFreeEventData : [FreeEventModelDetails]?
    var ActionListList = [DefaultValue.Pending.rawValue, DefaultValue.Approved.rawValue, DefaultValue.Rejected.rawValue]
    var segmentIndex = 0
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        searchTextField.delegate = self
        tableviewPromotionalEvent.delegate = self
        tableviewPromotionalEvent.dataSource = self
        callPromotionalListAPi()
        callFreePromotionalListAPI()
        
    }
    // MARK: - viewWillAppear
    override func viewWillAppear(_ animated: Bool) {
       
    }
    // MARK: - Create function for Promotional list APi call
    func callPromotionalListAPi(){
        promotionalViewModel.callPromotionalListApi {[weak self] data, isSuccess in
            if isSuccess == true{
                self?.managePromotionalData = data?.data
                self?.searchPromotionalData = data?.data
                self?.tableviewPromotionalEvent.reloadData()
            }
            else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Create function for getting free promotionla list
    func callFreePromotionalListAPI() {
        promotionalViewModel.callFreePromotionalListApi {[weak self] freeData, isSuccess in
            if isSuccess == true {
                self?.manageFreeEventData = freeData?.data
                self?.searchFreeEventData = freeData?.data
                self?.tableviewPromotionalEvent.reloadData()
            }else {
                self?.showSimpleAlert(message: freeData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Create function for select Promtional event
    /// create function for selecting Paid event and Free event
    /// - Parameter sender: UISegmentedControl
    /// - Return : nil
    @IBAction func promtionalEventSelection(_ sender: UISegmentedControl) {
        let selection = sender.selectedSegmentIndex
        segmentIndex = sender.selectedSegmentIndex
        switch selection {
        case 0:
            searchTextField.text = ""
            callPromotionalListAPi()
            
        case 1:
            searchTextField.text = ""
            callFreePromotionalListAPI()
        default:
            break
        }
    }
    // MARK: - Create function for Promotional list APi call
    func callAdminEventStatusApprovalAPi(action: Int, evntId: Int){
        promotionalViewModel.adminChangeEventStatusApi(action: action, evntId: evntId) {[weak self] data, isSuccess in
            if isSuccess == true{
                self?.callPromotionalListAPi()
                self?.callFreePromotionalListAPI()
                self?.tableviewPromotionalEvent.reloadData()
            }
            else{
                self?.showSimpleAlert(message: data?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    
    // MARK: - View Button Action
    ///Create function for view event Details
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapEye(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: EventDetailViewController.identifier) as! EventDetailViewController
        if segmentIndex == 0{
            vc.eventdetailsViewModel.id = self.searchPromotionalData?[sender.tag].events?.id ?? 0
        }else{
            vc.eventdetailsViewModel.id = self.searchFreeEventData?[sender.tag].events?.id ?? 0

        }
        self.navigationController?.pushViewController(vc , animated: true)
    }
  
  // MARK: - Back Button Action
    ///Create function for navigate to previous screen
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
// MARK: - Create extension for tableview Delegate
extension PromotionalEventViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        lblNorecordFound.isHidden = (segmentIndex == 0) ? ((searchPromotionalData?.count ?? 0 > 0) ? true : false) : ((searchFreeEventData?.count ?? 0 > 0) ? true : false)
        return (segmentIndex == 0) ? searchPromotionalData?.count ?? 0 : searchFreeEventData?.count ?? 0
        
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: PromotionalTableViewCell.identifier, for: indexPath) as! PromotionalTableViewCell
        if segmentIndex == 0{
            let data = searchPromotionalData?[indexPath.row]
            cell.lblEventTitle.text = "Event Title:- \(data?.events?.eventTitle ?? DefaultValue.emptyString.rawValue)"
            cell.lblPromoterName.text = "Promoter Name:- \(data?.promoter?.firstName ?? DefaultValue.emptyString.rawValue) " + (data?.promoter?.lastName ?? DefaultValue.emptyString.rawValue)
            cell.lblVenue.text = "Venue:- \(data?.events?.venue ?? DefaultValue.emptyString.rawValue)"
            cell.lblCategorytype.text = "Category Type:- \(data?.events?.category?.name ?? DefaultValue.emptyString.rawValue)"
            cell.lblEventStatus.text = "Event Status:- \(data?.eventStatus ?? DefaultValue.emptyString.rawValue)"
            cell.lblOrganizer.text = "Organizer:- \(data?.events?.organizer ?? DefaultValue.emptyString.rawValue)"
            cell.lblPaymentStatus.text = "Payment Status:- \(data?.paymentStatus ?? DefaultValue.emptyString.rawValue)"
            cell.viewButton.tag = indexPath.row
            cell.viewButton.addTarget(self, action: #selector(tapEye(sender: )), for: .touchUpInside)
            cell.showEventPaymentStatus(status: data?.status ?? 0)
            cell.actionTextField.optionArray = ActionListList
            cell.actionTextField.didSelect{(selectedText , index ,id) in
            self.callAdminEventStatusApprovalAPi(action: index, evntId: data?.id ?? 0)
                self.tableviewPromotionalEvent.reloadData()
            }
        }else{
            let data = searchFreeEventData?[indexPath.row]
            cell.lblEventTitle.text = "Event Title:- \(data?.events?.eventTitle ?? DefaultValue.emptyString.rawValue)"
            cell.lblPromoterName.text = "Promoter Name:- \(data?.promoter?.firstName ?? DefaultValue.emptyString.rawValue) " + (data?.promoter?.lastName ?? DefaultValue.emptyString.rawValue).capitalized
            cell.lblVenue.text = "Venue:- \(data?.events?.venue ?? DefaultValue.emptyString.rawValue)"
            cell.lblCategorytype.text = "Category Type:- \(data?.events?.category?.name ?? DefaultValue.emptyString.rawValue)"
            cell.lblEventStatus.text = "Event Status:- \(data?.eventStatus ?? DefaultValue.emptyString.rawValue)"
            cell.lblOrganizer.text = "Organizer:- \(data?.events?.organizer ?? DefaultValue.emptyString.rawValue)"
            cell.lblPaymentStatus.text = "Payment Status:- \("Free Event")"
            cell.viewButton.tag = indexPath.row
            cell.viewButton.addTarget(self, action: #selector(tapEye(sender: )), for: .touchUpInside)
            cell.showEventPaymentStatus(status: data?.status ?? 0)
            cell.actionTextField.optionArray = ActionListList
            cell.actionTextField.didSelect{(selectedText , index ,id) in
            self.callAdminEventStatusApprovalAPi(action: index, evntId: data?.id ?? 0)
                self.tableviewPromotionalEvent.reloadData()
            }
        }
        return cell
    }
    
    
}
// MARK: - Extention for TextFiled Delegate
///create function for seach data on basis of text
extension PromotionalEventViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if segmentIndex == 0{
            if let searchedText = searchTextField.text,
               let textRange = Range(range, in: searchedText){
                let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
                if updatedText != ""{
                    searchPromotionalData = managePromotionalData?.filter({ values in
                        return (values.events?.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.promoter?.firstName ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.events?.category?.name ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                    })
                }else{
                    searchPromotionalData = managePromotionalData
                }
                tableviewPromotionalEvent.reloadData()
            }
            return true
        }else{
            if let searchedText = searchTextField.text,
               let textRange = Range(range, in: searchedText){
                let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
                if updatedText != ""{
                    searchFreeEventData = manageFreeEventData?.filter({ values in
                        return (values.events?.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.promoter?.firstName ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.events?.category?.name ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                        
                    })
                }else{
                    searchFreeEventData = manageFreeEventData
                }
                tableviewPromotionalEvent.reloadData()
            }
            return true
        }
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
