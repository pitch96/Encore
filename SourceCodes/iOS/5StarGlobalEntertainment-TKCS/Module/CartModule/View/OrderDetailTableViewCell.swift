//
//  OrderDetailTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 09/01/23.
//

import UIKit

class OrderDetailTableViewCell: UITableViewCell {

    @IBOutlet weak var lblPrice: UILabel!
    @IBOutlet weak var lblDiscount: UILabel!
    @IBOutlet weak var totalPrice: UILabel!
    @IBOutlet weak var placeOrderButton: UIButton!
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
