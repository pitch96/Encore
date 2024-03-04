//
//  ManagePromoterTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import UIKit

class ManagePromoterTableViewCell: UITableViewCell {
    
    @IBOutlet weak var lblName: UILabel!
    @IBOutlet weak var labelEmail: UILabel!
    @IBOutlet weak var lblPhone: UILabel!
    @IBOutlet weak var deleteButton: UIButton!
    @IBOutlet weak var editButton: UIButton!
    @IBOutlet weak var verifyPromoter: UISwitch!
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }
    // MARK: - Create function for popular button on/Off
    func changePromoterStatus(ownPromoter: Int) {
        switch ownPromoter {
        case 0:
            verifyPromoter.isOn = false
            
        case 1:
            verifyPromoter.isOn = true
            
        default:
            debugPrint("Default")
        }
    }
    @IBAction func editPrfileButton(_ sender: Any) {
       
    }
    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
