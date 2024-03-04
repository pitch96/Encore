//
//  EventOrderTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/04/23.
//

import UIKit

class EventOrderTableViewCell: UITableViewCell {
  // MARK: IBOutlets--
    @IBOutlet weak var lblTitleEvent: UILabel!
    @IBOutlet weak var lblstartDateTime: UILabel!
    @IBOutlet weak var lblTicketSold: UILabel!
    @IBOutlet weak var lblEndDateTime: UILabel!
    @IBOutlet weak var lblAmount: UILabel!
    @IBOutlet weak var lblGuestCount: UILabel!
    @IBOutlet weak var seeeOrderButton: UIButton!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
