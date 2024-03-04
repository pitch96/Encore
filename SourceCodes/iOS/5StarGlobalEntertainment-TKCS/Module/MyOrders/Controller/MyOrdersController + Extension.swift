//
//  MyOrdersController + Extension.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import Foundation
import UIKit

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
}


// MARK: - UITABLEVIEW DELEGATE & DATASOURCE
extension MyOrdersController: UITableViewDelegate, UITableViewDataSource {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return myOrderViewModel.eventModeldata.count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        guard let cell = myOrderstableView.dequeueReusableCell(withIdentifier: MyOrdersCell.identifier, for: indexPath) as?
                MyOrdersCell else {return UITableViewCell()}
        let data = self.myOrderViewModel.eventModeldata[indexPath.row]
        cell.labelEventTitle.text = "Event Title: \( data.eventTitle)"
        cell.labelTicketTitle.text = "Ticket Title: \( data.ticketTitle)"
        cell.labelTicketType.text = "Ticket Type: \( data.ticketType)"
        cell.labelQuantity.text = "Quantity: \( data.quantity)"
        cell.labelPrice.text = "Price: \( data.price)"
        cell.labelTotalPrice.text = "Total Price: \( data.totalPrice)"
        cell.labelDate.text = "Date: \( data.date)"
        return cell
    }
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
        return UITableView.automaticDimension
    }
}
