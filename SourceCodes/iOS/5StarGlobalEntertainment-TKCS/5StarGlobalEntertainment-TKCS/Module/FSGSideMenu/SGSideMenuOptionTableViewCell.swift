//
//  SGSideMenuOptionTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 23/11/22.
//

import UIKit

class SGSideMenuOptionTableViewCell: UITableViewCell {

    @IBOutlet weak var optionButton: UIButton!
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

    @IBAction func profileClicked(_ sender: Any) {
    }
}
