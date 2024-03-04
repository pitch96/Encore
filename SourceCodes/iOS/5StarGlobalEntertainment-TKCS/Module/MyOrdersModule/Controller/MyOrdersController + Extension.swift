//
//  MyOrdersController + Extension.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import Foundation
import UIKit
import SDWebImage

// MARK: - FUNCTIONS
extension MyOrdersController{
    ////function to add custom UI Inputs and customize UI
    func setCustomUI(){
        self.registerTVCell()
    }
    ////function to register and set up Tableview cell
    func registerTVCell(){
        
        self.myOrderstableView.delegate = self
        self.myOrderstableView.dataSource = self
        self.myOrderstableView.register(UINib(nibName: MyOrdersCell.identifier, bundle: nil), forCellReuseIdentifier: MyOrdersCell.identifier)
        self.myOrderstableView.separatorStyle = .none
        self.myOrderstableView.reloadData()
    }
    // MARK: - Information Button Action
    ///Create function for view ticket information
    ////// - Parameter sender: UIButton
    /// return : nil
    @objc func tapInformation(sender: UIButton){
        let vc = self.storyboard?.instantiateViewController(withIdentifier: TicketDetailsViewController.identifier) as! TicketDetailsViewController
        vc.ticketViewModel.id = orderModel?[sender.tag].id ?? 0
        self.navigationController?.pushViewController(vc , animated: true)
    }
}

// MARK: - UITABLEVIEW DELEGATE & DATASOURCE
extension MyOrdersController: UITableViewDelegate, UITableViewDataSource {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if orderModel?.count == 0 {
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return orderModel?.count ?? 0
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = myOrderstableView.dequeueReusableCell(withIdentifier: MyOrdersCell.identifier, for: indexPath) as?
                MyOrdersCell else {return UITableViewCell()}
        let data = orderModel?[indexPath.row]
        cell.labelEventTitle.text = "Event Title: \(data?.orderDetails?.eventTitle?.capitalized ?? DefaultValue.emptyString.rawValue)"
        cell.labelTicketTitle.text = "Ticket Title: \( data?.orderDetails?.ticketTitle ?? DefaultValue.emptyString.rawValue)"
        cell.labelTicketType.text = "Ticket Type: \(data?.orderDetails?.ticketType ?? DefaultValue.emptyString.rawValue)"
        cell.labelQuantity.text = "Qty: \( data?.orderDetails?.ticketPurchaseQty ?? 0)"
        cell.labelPrice.text = "PR: $\( data?.orderDetails?.ticketPrice ?? 0)"
        if let imageURL = data?.orderDetails?.eventImage{
        let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
        cell.imageEvent.sd_imageIndicator = SDWebImageActivityIndicator.gray
        cell.imageEvent.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
                    }
                }else{
                    //cell.event.image =
                }
        cell.labelDate.text = "Date: \(data?.orderPlacedDate ?? DefaultValue.emptyString.rawValue)"
        cell.informationButton.tag = indexPath.row
        cell.informationButton.addTarget(self, action: #selector(tapInformation(sender: )), for: .touchUpInside)
        return cell
    }
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return UITableView.automaticDimension
    }
}
