//
//  GuestListViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 04/04/23.
//

import UIKit
import SDWebImage

class GuestListViewController: UIViewController {
    
// MARK: IBOutlets--
    @IBOutlet weak var tableviewGuestList: UITableView!
    @IBOutlet weak var lblNoRecord: UILabel!
    // MARK: Variable Initializer--
    var selectedSegmentIndex = 0
    lazy var guestListViewModel:GuestUserViewModel = {
        var guestListViewModel = GuestUserViewModel()
        return guestListViewModel
    }()
    var manageGuestData: [GuestListDetail]?
    var runningOrder: [Order]?
    var expiredOrder: [Order1]?


    var Id : Int?
    
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
           tableviewGuestList.delegate = self
           tableviewGuestList.dataSource = self
           callGuestListById()
       
    }
    
    // MARK: - Create function for calling Guest list Api
    func callGuestListById(){
        guestListViewModel.callGuestUserApi(id: Id ?? 0) {[weak self] guestData, isSuccess in
            if isSuccess == true{
                self?.manageGuestData = guestData?.data                
                self?.tableviewGuestList.reloadData()
            }else{
                self?.showSimpleAlert(message: guestData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    
    // MARK: - Back Button Action
    /// create action for back to previous screen
    /// - Parameter sender: UIButton
    /// - Return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    // MARK: - Create function for decode data

}

// MARK: - Create extension for tableview delegate and datasource
extension GuestListViewController: UITableViewDelegate, UITableViewDataSource {
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        let count = manageGuestData?.count ?? 0
        if count > 0 {
            lblNoRecord.isHidden = true
        } else {
            lblNoRecord.isHidden = false
        }
        return count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: GuestListTableViewCell.identifier, for: indexPath) as!
        GuestListTableViewCell
        let rData = runningOrder?[indexPath.row]
        let eData = expiredOrder?[indexPath.row]
        if runningOrder?.count ?? 0 > 0 {
            cell.lblUsername.text = "\(rData?.firstName ?? DefaultValue.emptyString.rawValue) \(rData?.lastName ?? DefaultValue.emptyString.rawValue)".capitalized
        } else {
            cell.lblUsername.text = "\(eData?.firstName ?? DefaultValue.emptyString.rawValue) \(eData?.lastName ?? DefaultValue.emptyString.rawValue)".capitalized
        }
        let data = manageGuestData?[indexPath.row]
        cell.lblScannerTicket.text = "Ticket Scanned:- \(data?.ticketsChecked ?? 0)"
        cell.lblOrderDate.text = "Order Date:- \(data?.orderPlacedDate ?? "")"
        cell.lblTicketType.text = "TicketType:- \(data?.orderDetails?.ticketType ?? "")"
        cell.lblTicketQty.text = "Qty:- \(data?.orderDetails?.ticketPurchaseQty ?? 0)"
        cell.lblPrice.text = "Pr:- \(data?.orderDetails?.ticketPrice ?? 0)"
        cell.lblTicketTitle.text = data?.orderDetails?.ticketTitle?.capitalized
        let imageUrl = URL(string: data?.orderDetails?.eventImage ?? "" )
        cell.eventImage.sd_setImage(with: imageUrl)
        
        return cell
        
    }
}
