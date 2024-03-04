//
//  ManageTicketTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/02/23.
//

import UIKit

class ManageTicketTableViewCell: UITableViewCell {

    @IBOutlet weak var lblTicketTitle: UILabel!
    @IBOutlet weak var buttonSwitch: UISwitch!
    @IBOutlet weak var lblEventTitle: UILabel!
    @IBOutlet weak var lblTicketType: UILabel!
    @IBOutlet weak var lblTicketStatus: UILabel!
    @IBOutlet weak var editButton: UIButton!
    @IBOutlet weak var deleteButton: UIButton!
    @IBOutlet weak var lblPrice: UILabel!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }
    // MARK: create function for change switch action--
    func showTicketStatus(status:Int){
        
        switch status{
        case 0:
            buttonSwitch.isOn = false
            
        case 1:
            buttonSwitch.isOn = true
            
        default:
            debugPrint("Default")
        }
        
        
    }

}
