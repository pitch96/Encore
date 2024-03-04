//
//  SubscriberListTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/03/23.
//

import UIKit

class SubscriberListTableViewCell: UITableViewCell {
    // MARK: IBOtlets--
    @IBOutlet weak var lblSubscriber: UILabel!
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }
    
    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)
        
        // Configure the view for the selected state
    }
    
}
