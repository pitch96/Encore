//
//  ManageBannerImagesTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/03/23.
//

import UIKit

class ManageBannerImagesTableViewCell: UITableViewCell {
// MARK: IBOutlets--
    @IBOutlet weak var bannerImage: UIImageView!
    @IBOutlet weak var lblDescription: UILabel!
    @IBOutlet weak var editButton: UIButton!
    @IBOutlet weak var deleteButton: UIButton!
    @IBOutlet weak var switchButton: UISwitch!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }
    // MARK: create function for change switch action--
    func manageBannerStatus(status:Int){
        
        switch status{
        case 0:
            switchButton.isOn = false
            
        case 1:
            switchButton.isOn = true
            
        default:
            debugPrint("Default")
        }
        
        
    }
}
