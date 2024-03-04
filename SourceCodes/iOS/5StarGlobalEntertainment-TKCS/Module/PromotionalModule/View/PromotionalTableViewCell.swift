//
//  PromotionalTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 12/04/23.
//

import UIKit
import iOSDropDown

class PromotionalTableViewCell: UITableViewCell, UITextFieldDelegate {
    // MARK: IBOutlets--
    @IBOutlet weak var lblPromoterName: UILabel!
    @IBOutlet weak var lblEventTitle: UILabel!
    @IBOutlet weak var lblCategorytype: UILabel!
    @IBOutlet weak var lblOrganizer: UILabel!
    @IBOutlet weak var lblVenue: UILabel!
    @IBOutlet weak var lblEventStatus: UILabel!
    @IBOutlet weak var lblPaymentStatus: UILabel!
    @IBOutlet weak var actionTextField: DropDown!
    @IBOutlet weak var viewButton: UIButton!
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
        actionTextField.delegate = self
       
    }
    // MARK: Create function for Payment Status--
    func showEventPaymentStatus(status:Int){
        switch status {
        case 0:
            actionTextField.text = "Pending"
            actionTextField.backgroundColor = UIColor.yellow
            actionTextField.textColor = UIColor.black
        case 1:
            actionTextField.text = "Approved"
            //actionTextField.isUserInteractionEnabled = false
            actionTextField.backgroundColor = UIColor.green
            actionTextField.textColor = UIColor.black
        case 2:
            actionTextField.text = "Rejected"
            actionTextField.backgroundColor = UIColor.red
            actionTextField.textColor = UIColor.black
        default:
            break
        }
        
    }
    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
