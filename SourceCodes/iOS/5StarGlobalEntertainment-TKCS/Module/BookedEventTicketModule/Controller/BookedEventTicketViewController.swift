//
//  BookedEventTicketViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 23/03/23.
//

import UIKit
import SDWebImage

class BookedEventTicketViewController: UIViewController {
   // MARK: - IBOutlet
    @IBOutlet weak var txtTotalSoldTicket: UITextField!
    @IBOutlet weak var eventImage: UIImageView!
    @IBOutlet weak var txtGuestArrived: UITextField!
    @IBOutlet weak var lblSoldTicket: UILabel!
    @IBOutlet weak var lblGuestArrived: UILabel!
    @IBOutlet weak var viewSoldTicket: CustomView!
    @IBOutlet weak var viewGuestArrived: CustomView!
    // MARK: Variable Initializer--
    lazy var bookedEventDetailsViewModel: BookedEventDetailViewModel = {
        var bookedEventDetailsViewModel = BookedEventDetailViewModel()
        return bookedEventDetailsViewModel
    }()
    var ticketModel : BookedEventDetailModel?
    var eventModel: EventDetailModel?
    // MARK: - viewDidload
    override func viewDidLoad() {
        super.viewDidLoad()
        eventImage.isHidden = true
        txtGuestArrived.isHidden = true
        txtTotalSoldTicket.isHidden = true
        viewSoldTicket.isHidden = true
        viewGuestArrived.isHidden = true
        lblSoldTicket.isHidden = true
        lblGuestArrived.isHidden = true
        getBookedEventDetails()
    }
    // MARK: - Create function for get ticket detail by event Id
    func getBookedEventDetails(){
        bookedEventDetailsViewModel.callBookedEventDetailApi(id: bookedEventDetailsViewModel.id) {[weak self] BookedDetails, isSuccess in
            if isSuccess == true{
                self?.txtTotalSoldTicket.text = String(BookedDetails.data?.totalTicketsSold ?? 0)
                self?.txtGuestArrived.text = String(BookedDetails.data?.guestsArrived ?? 0)
                if let imageURL = self?.bookedEventDetailsViewModel.image {
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    let imageString = "https://encoreevents.live/event-images/" + urlString
                    self?.eventImage.sd_setImage(with: URL(string: imageString))}
                self?.eventImage.sd_imageIndicator = SDWebImageActivityIndicator.gray
                DispatchQueue.main.async {
                    self?.showUI(hide: false)
                }
            }else{
                DispatchQueue.main.async {
                    self?.showUI(hide: true)
                    self?.refreshAlert(title: Alert.projectName, message: BookedDetails.message ?? DefaultValue.errorMsg.rawValue)
                   }
            }
        }
    }
    // MARK: - Back Button Action
    ///Create action for navigate to previous screen
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: - Create function for hide Content
    ///manage user interface for booked event
    func showUI(hide: Bool) {
        eventImage.isHidden = hide
        txtGuestArrived.isHidden = hide
        txtTotalSoldTicket.isHidden = hide
        viewSoldTicket.isHidden = hide
        viewGuestArrived.isHidden = hide
        lblSoldTicket.isHidden = hide
        lblGuestArrived.isHidden = hide
    }

}
