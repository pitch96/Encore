//
//  ManageEventTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 05/01/23.
//

import UIKit

class ManageEventTableViewCell: UITableViewCell {
   // MARK: IBOutlets--
    @IBOutlet weak var titleLabel: UILabel!
    @IBOutlet weak var categoryType: UILabel!
    @IBOutlet weak var isLive: UISwitch!
    @IBOutlet weak var createdByLabel: UILabel!
    @IBOutlet weak var eventStatusLabel: UILabel!
    @IBOutlet weak var eyeButton: UIButton!
    @IBOutlet weak var deleteButton: UIButton!
    @IBOutlet weak var editButton: UIButton!
    @IBOutlet weak var lblEventStatus: UILabel!
    @IBOutlet weak var lblApproval: UILabel!
    @IBOutlet weak var isApprovalHeightConstrainsts: NSLayoutConstraint!
    @IBOutlet weak var lblMakePopular: UILabel!
    @IBOutlet weak var popularEventStatus: UISwitch!
    
    @IBOutlet weak var makePopularHieghtConstraints: NSLayoutConstraint!
    @IBOutlet weak var switchPopularHeightConstraints: NSLayoutConstraint!
    
    // MARK: awakeFromNib--
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
        // MARK: - Hide and Show lblApproval
        
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        switch userType{
        case 1:
            
            lblApproval.isHidden = true
            isApprovalHeightConstrainsts.constant = 0
        case 3:
            lblApproval.isHidden = false
           // lblMakePopular.isHidden = true
            isApprovalHeightConstrainsts.constant = 19
        default:
            break
        }
        
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }
    
    // MARK: - Create function for hide and show toggle for admin and promoter
    func HideIsPopularForPromoter(){
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        switch userType{
        case 1:
            lblMakePopular.isHidden = false
            popularEventStatus.isHidden = false
            makePopularHieghtConstraints.constant = 25
            switchPopularHeightConstraints.constant = 27
            
            
        case 3:
            lblMakePopular.isHidden = true
            popularEventStatus.isHidden = true
            makePopularHieghtConstraints.constant = 0
            switchPopularHeightConstraints.constant = 0
        default:
            break
        }
    }
    // MARK: - Create function for change event status
    func showEventStatus(status:Int){
        switch status{
        case 0:
            isLive.isOn = false
            
        case 1:
            isLive.isOn = true
            
        default:
            debugPrint("Default")
        }
    }
    // MARK: - Create function for popular events status
    func changePopularStatus(isPopular: Int) {
        
        if isLive.isOn {
            switch isPopular {
            case 0:
                popularEventStatus.isOn = false
                
            case 1:
                popularEventStatus.isOn = true
                
            default:
                debugPrint("Default")
            }
        }else{
            
            popularEventStatus.isOn = false
        }
        
        
    }
  
    // MARK: Show Event status Approval--
//    func showEventApprovalStatus(status:Int?){
//
//        if let approvalStatus = status {
//            switch approvalStatus{
//            case 0:
//                lblApproval.text = "In-Progress"
//                lblApproval.backgroundColor = UIColor.yellow
//                lblApproval.textColor = UIColor.black
//
//            case 1:
//                lblApproval.text = "Approved"
//                lblApproval.backgroundColor = UIColor.green
//                lblApproval.textColor = UIColor.black
//            case 2:
//                lblApproval.text = "Rejected"
//                lblApproval.backgroundColor = UIColor.red
//                lblApproval.textColor = UIColor.black
//            default:
//                debugPrint("Default")
//            }
//        }
//            else{
//            lblApproval.text = "Pay $1000"
//            lblApproval.backgroundColor = UIColor.cyan
//            lblApproval.textColor = UIColor.black
//        }
//
//
//    }

}
