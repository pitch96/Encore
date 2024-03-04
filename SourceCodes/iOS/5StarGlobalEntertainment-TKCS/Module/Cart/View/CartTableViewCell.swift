//
//  CartTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 09/01/23.
//

import UIKit

class CartTableViewCell: UITableViewCell {
    
    @IBOutlet weak var lblEmptyCart: UILabel!
    @IBOutlet weak var eventImage: UIImageView!
    @IBOutlet weak var eventTitle: UILabel!
    @IBOutlet weak var ticketTitle: UILabel!
    @IBOutlet weak var lblShowQuantity: UILabel!
    @IBOutlet weak var lblUnitPrice: UILabel!
    @IBOutlet weak var lblAmmount: UILabel!
    @IBOutlet weak var increaseButton: UIButton!
    @IBOutlet weak var decreaseButton: UIButton!
    @IBOutlet weak var deleteButton: UIButton!
    
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
       
       
    }
    
}
