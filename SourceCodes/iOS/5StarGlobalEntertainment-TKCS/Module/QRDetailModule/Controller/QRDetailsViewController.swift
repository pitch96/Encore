//
//  QRDetailsViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 15/03/23.
//

import UIKit

class QRDetailsViewController: UIViewController {
    // MARK: IBoutlets--
    @IBOutlet weak var ticketImage: UIImageView!
    @IBOutlet weak var scanButton: UIButton!
    @IBOutlet weak var lblTicketStatus: UILabel!
    
    // MARK: Variable Initializer--
    var ticketStatus: ticketTitle?
    var otherTicketmsg = ""
    var callBack:(()->Void)?
    // MARK: ViewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        scanButton.layer.cornerRadius = 20
        setTicketStatusUI()
    }
    // MARK: Create function for manage UserInterface with Ticket Status--
    private func setTicketStatusUI(){
        guard let status = ticketStatus else {return}
        switch status{
        case .wrongTicket:
            ticketImage.image = UIImage(named:DefaultValue.WrongTicket.rawValue)
            lblTicketStatus.text = DefaultValue.WrongTicket.rawValue
        case .guestArrived:
            ticketImage.image = UIImage(named: DefaultValue.ValidTicket.rawValue)
            lblTicketStatus.text = DefaultValue.GuestArrived.rawValue
        case .alreadyCheckIn:
            ticketImage.image = UIImage(named: DefaultValue.AlreadyScanned.rawValue)
            lblTicketStatus.text = DefaultValue.AlreadyCheckIn.rawValue
        case .otherEventTicket:
            ticketImage.image = UIImage(named: DefaultValue.WrongTicket.rawValue)
            lblTicketStatus.text = otherTicketmsg
        }
    }
    // MARK: Scan TIcket Action Button--
    /// Create Function For navigate to scanner screen
    /// - Parameter sender: UIButton
    /// return :nil
    @IBAction func ScanAnotherTicketAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Back Button Action--
    /// Create Function For navigate to Home screen
    /// - Parameter sender: UIButton
    /// return :nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: false)
        self.callBack?()
    }
}
// MARK: Create Enum For manage Ticket Status--
enum ticketTitle {
case wrongTicket
case guestArrived
case alreadyCheckIn
case otherEventTicket
}
