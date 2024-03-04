//
//  ManageCategoryTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 04/02/23.
//

import UIKit

class ManageCategoryTableViewCell: UITableViewCell {
    // MARK: IBOutlets--
    @IBOutlet weak var lblName: UILabel!
    @IBOutlet weak var editButton: UIButton!
    @IBOutlet weak var deleteButton: UIButton!
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
