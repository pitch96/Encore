//
//  GuestListTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 04/04/23.
//

import UIKit

class GuestListTableViewCell: UITableViewCell {
// MARK: IBOutlets--
    @IBOutlet weak var lblUsername: UILabel!
    @IBOutlet weak var lblOrderDate: UILabel!
    @IBOutlet weak var lblScannerTicket: UILabel!
    @IBOutlet weak var lblPrice: UILabel!
    @IBOutlet weak var lblTicketQty: UILabel!
    @IBOutlet weak var lblTicketType: UILabel!
    @IBOutlet weak var eventImage: UIImageView!
    @IBOutlet weak var lblTicketTitle: UILabel!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
