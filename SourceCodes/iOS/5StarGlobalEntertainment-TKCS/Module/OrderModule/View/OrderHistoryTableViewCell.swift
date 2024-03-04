//
//  OrderHistoryTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/03/23.
//

import UIKit

class OrderHistoryTableViewCell: UITableViewCell {
// MARK: IBOutlets--
    
    @IBOutlet weak var lblEventTitle: UILabel!
    @IBOutlet weak var imageEvent: UIImageView!
    @IBOutlet weak var lblUserName: UILabel!
    @IBOutlet weak var lblTicketTitle: UILabel!
    @IBOutlet weak var lblTicketType: UILabel!
    @IBOutlet weak var lblOrderDate: UILabel!
    @IBOutlet weak var lblQuantity: UILabel!
    @IBOutlet weak var lblPrice: UILabel!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
