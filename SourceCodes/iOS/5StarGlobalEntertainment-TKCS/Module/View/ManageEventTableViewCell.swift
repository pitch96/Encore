//
//  ManageEventTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 05/01/23.
//

import UIKit

class ManageEventTableViewCell: UITableViewCell {

    @IBOutlet weak var titleLabel: UILabel!
    @IBOutlet weak var categoryType: UILabel!
    @IBOutlet weak var organiserLabel: UILabel!
    @IBOutlet weak var venueLabel: UILabel!
    @IBOutlet weak var timeLabel: UILabel!
    @IBOutlet weak var isLive: UISwitch!
    @IBOutlet weak var createdByLabel: UILabel!
    @IBOutlet weak var eventStatusLabel: UILabel!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
