//
//  MyOrdersCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import UIKit

class MyOrdersCell: UITableViewCell {
    // MARK: IBOUTLET
    @IBOutlet weak var labelEventTitle: UILabel!
    @IBOutlet weak var labelQuantity: UILabel!
    @IBOutlet weak var labelDate: UILabel!
    @IBOutlet weak var labelTicketTitle: UILabel!
    @IBOutlet weak var labelPrice: UILabel!
    @IBOutlet weak var labelTicketType: UILabel!
    @IBOutlet weak var informationButton: UIButton!
    @IBOutlet weak var imageEvent: UIImageView!
    
    override func awakeFromNib() {
        super.awakeFromNib()
       
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }
    
}
