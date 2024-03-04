//
//  EventDetailViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 08/02/23.
//

import UIKit

class EventDetailViewController: UIViewController {
    // MARK: IBOulets--
    @IBOutlet weak var lblCategoryName: UILabel!
    @IBOutlet weak var lblTitle: UILabel!
    @IBOutlet weak var lblEventDescription: UILabel!
    @IBOutlet weak var lblVenue: UILabel!
    @IBOutlet weak var lblAddress: UILabel!
    @IBOutlet weak var lblCity: UILabel!
    @IBOutlet weak var lblZipCode: UILabel!
    @IBOutlet weak var lblOrganizerName: UILabel!
    @IBOutlet weak var lblStartDateAndTime: UILabel!
    @IBOutlet weak var lblEndDateAndTime: UILabel!
    @IBOutlet weak var lblEventStatus: UILabel!
    @IBOutlet weak var imageEvent: UIImageView!
    @IBOutlet weak var makeLiveButton: UIButton!
    @IBOutlet weak var referLinkButton: UIButton!
    @IBOutlet weak var liveNowButton: UIButton!
    @IBOutlet weak var lblevntPermission: UILabel!
    @IBOutlet weak var getAccessButton: UIButton!
    
    @IBOutlet weak var warningStackView: UIStackView!
    @IBOutlet weak var LiveNowStackView: UIStackView!
    
    // MARK: Variable initializer--
    var data : EventDetails?
    var eventDetailModel = EventDetailModel()
    lazy var eventdetailsViewModel:EventDetailViewModel = {
        var eventdetailsViewModel = EventDetailViewModel()
        return eventdetailsViewModel
    }()
    var start = String()
    var end = String()
    var selectedSegment = 0
    var isLiveOn = 0
    var timer: Timer!
    var eventID = Int()

    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        if selectedSegment == 1{
            warningStackView.isHidden = true
            LiveNowStackView.isHidden = true
        }else{
            warningStackView.isHidden = false
            LiveNowStackView.isHidden = false
        }
        makeLiveButton.layer.cornerRadius = 10
        referLinkButton.layer.cornerRadius = 10
        liveNowButton.layer.cornerRadius = 10
        getEventDetailApi()
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    
    // MARK: Create function for calling Event Detail APi--
    func getEventDetailApi(){
        eventdetailsViewModel.callGetEventDetailsApi(id: eventdetailsViewModel.id) { [weak self]eventDetailsData, isSuccess in
            if isSuccess == true{
                if  let detailsData = eventDetailsData{
                    self?.eventDetailModel = detailsData
                }
                DispatchQueue.main.async {
                    self?.timer = Timer.scheduledTimer(timeInterval: 1, target: self!, selector: #selector(self?.UpdateTime), userInfo: nil, repeats: true) // Repeat "func Update() " every second and update the label
                }
                //self?.isLiveOn = eventDetailsData?.data?.status ?? 0
                let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
                debugPrint(UserDefaults.standard.value(forKey:Tokenkey.UsersTypes) ?? 0)
                switch userType {
                case 3:
                    //self?.isLiveOn = eventDetailsData?.data?.promotionEvent
                    self?.isLiveOn = eventDetailsData?.data?.promotionEvent?.status ?? 0
                    if eventDetailsData?.data?.event?.status == 0  && self?.isLiveOn == 1 {
                        self?.getAccessButton.isHidden = true
                        self?.makeLiveButton.isHidden = false
                        self?.referLinkButton.isHidden = true
                        self?.liveNowButton.isHidden = true
                        self?.lblevntPermission.isHidden = true
                    }else if eventDetailsData?.data?.event?.status == 1 && self?.isLiveOn == 1 {
                        self?.makeLiveButton.isHidden = true
                        self?.getAccessButton.isHidden = true
                        self?.referLinkButton.isHidden = false
                        self?.liveNowButton.isHidden = false
                        self?.lblevntPermission.isHidden = true
                    }else if eventDetailsData?.data?.event?.status == 0 && self?.isLiveOn == 0{
                        self?.lblevntPermission.text = AppMessage.shared.AdminApproval
                        self?.makeLiveButton.isHidden = true
                        self?.getAccessButton.isHidden = true
                        self?.referLinkButton.isHidden = true
                        self?.liveNowButton.isHidden = true
                        self?.lblevntPermission.isHidden = true
                    }else if eventDetailsData?.data?.event?.status == 0 && self?.isLiveOn == 2 {
                        self?.makeLiveButton.isHidden = true
                        self?.getAccessButton.isHidden = true
                        self?.referLinkButton.isHidden = true
                        self?.liveNowButton.isHidden = true
                        self?.lblevntPermission.isHidden = false
                        self?.lblevntPermission.text = AppMessage.shared.RejectedRequest
                    }else{
                        self?.getAccessButton.isHidden = false
                        self?.makeLiveButton.isHidden = true
                        self?.referLinkButton.isHidden = true
                        self?.liveNowButton.isHidden = true
                        self?.lblevntPermission.isHidden = true
                    }
                case 1:
                    self?.getAccessButton.isHidden = true
                    self?.makeLiveButton.isHidden = true
                    self?.referLinkButton.isHidden = true
                    self?.liveNowButton.isHidden = true
                    self?.lblevntPermission.isHidden = true
                default:
                    break
                }
                self?.lblCategoryName.text = "  \(eventDetailsData?.data?.event?.category?.name ?? DefaultValue.emptyString.rawValue)"
                self?.lblTitle.text = "  \(eventDetailsData?.data?.event?.eventTitle?.capitalized ?? DefaultValue.emptyString.rawValue)"
                self?.lblEventDescription.text = eventDetailsData?.data?.event?.description
                self?.lblVenue.text = "Venue :- \(eventDetailsData?.data?.event?.venue ?? DefaultValue.emptyString.rawValue)"
                self?.lblAddress.text = "Address :- \(eventDetailsData?.data?.event?.address ?? DefaultValue.emptyString.rawValue)"
                self?.lblCity.text = "City :- \(eventDetailsData?.data?.event?.city ?? DefaultValue.emptyString.rawValue)"
                self?.lblZipCode.text = "Zipcode :- \(eventDetailsData?.data?.event?.zipcode ?? DefaultValue.emptyString.rawValue)"
                self?.lblOrganizerName.text = "Name :- \(eventDetailsData?.data?.event?.organizer ?? DefaultValue.emptyString.rawValue)"
                self?.lblStartDateAndTime.text = "Start Date And Time:- \(eventDetailsData?.data?.event?.startDate ?? DefaultValue.emptyString.rawValue)" + "   " +   (eventDetailsData?.data?.event?.startTime ?? DefaultValue.emptyString.rawValue)
                self?.lblEndDateAndTime.text = "End Date And Time:-  \(eventDetailsData?.data?.event?.endDate ?? DefaultValue.emptyString.rawValue)" + "    " +   (eventDetailsData?.data?.event?.endTime ?? DefaultValue.emptyString.rawValue)
                self?.start = eventDetailsData?.data?.event?.startDate ?? DefaultValue.emptyString.rawValue
                self?.end = eventDetailsData?.data?.event?.endDate ?? DefaultValue.emptyString.rawValue
                if let imageURL = eventDetailsData?.data?.event?.image{
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    self?.imageEvent.sd_setImage(with: URL(string: urlString))}
            }else{
                self?.showSimpleAlert(message: eventDetailsData?.message ?? DefaultValue.emptyString.rawValue)
            }
            
        }
    }
    // MARK: Create function for show Timer--
    override func viewDidDisappear(_ animated: Bool) {
        timer.invalidate()
    }
    // MARK: Get Access Button Action--
    /// create function for navigate to payment screen
    /// - Parameter sender: UIButton
    /// - Return : nil
    @IBAction func getAccessButtonAction(_ sender: UIButton) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: PromoterPaymentViewController.identifier) as! PromoterPaymentViewController
        self.navigationController?.pushViewController(vc, animated: true)
    }
    // MARK: Live Button Action--
    /// create function for calling status Api
    /// - Parameter sender: UIButton
    /// - Return : nil
    @IBAction func LiveNowButtonAction(_ sender: UIButton) {
        self.callStatusApi()
    }
    // MARK: ReferLink Button Action--
    /// create function for Calling reffer link API
    /// - Parameter sender: UIButton
    /// - Return : nil
    @IBAction func ReferLinkButtonAction(_ sender: UIButton) {
        eventdetailsViewModel.callReferLinkApi(eventID: eventDetailModel.data?.event?.id) { data, isSuccess in
            if isSuccess == true{
                let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.RefferalMsg, preferredStyle: .alert)
                //2. Add the text field. You can configure it however you need.
                alert.addTextField { (textField) in
                    textField.text = data?.data
                }
                // 3. Grab the value from the text field, and print it when the user clicks OK.
                alert.addAction(UIAlertAction(title: Alert.copy, style: UIAlertAction.Style.default, handler: { [weak alert] (_) in
                    let textField = alert?.textFields![0] // Force unwrapping because we know it exists.
                    debugPrint("Text field: \(textField?.text ?? DefaultValue.emptyString.rawValue)")
                    UIPasteboard.general.string = textField?.text ?? DefaultValue.emptyString.rawValue
                }))
                alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
                // 4. Present the alert.
                self.present(alert, animated: true, completion: nil)
            }else{
               // self.showSimpleAlert(message: data?.message)
            }
        }
    }


    // MARK: Back Button Action--
    /// create function for navigate to payment screen
    /// - Parameter sender: UIButton
    /// - Return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
        
    }
    // MARK: - Live Button Action
    /// create function for navigate to live and status api call
    /// - Parameter sender: UIButton
    /// - Return : nil
    @IBAction func liveButtonAction(_ sender: Any) {
        let alert = UIAlertController(title: Alert.projectName, message: AppMessage.shared.LiveEvent, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: {(action:UIAlertAction!) in
            self.callMakeliveStatusApi()
        }))
        alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.default, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    // MARK: - Create function for change status of make live
    func callMakeliveStatusApi() {
        eventdetailsViewModel.callStatusApi(eventId: eventdetailsViewModel.id, status: eventDetailModel.data?.promotionEvent?.status ?? 0) {[weak self] statusChange, isSuccess in
            if isSuccess == true{
                self?.referLinkButton.isHidden = false
                self?.liveNowButton.isHidden = false
                self?.makeLiveButton.isHidden = true
                self?.showSimpleAlert(message: statusChange?.message ?? DefaultValue.emptyString.rawValue)
            }else{
                self?.showSimpleAlert(message: statusChange?.message ?? DefaultValue.emptyString.rawValue)
            }
        }
    }
    
    // MARK: - Create function for calling Status Api
    func callStatusApi(){
        eventdetailsViewModel.callStatusApi(eventId: eventdetailsViewModel.id, status: eventDetailModel.data?.promotionEvent?.status ?? 0) {[weak self] statusChange, isSuccess in
            if isSuccess == true{
                self?.referLinkButton.isHidden = true
                self?.liveNowButton.isHidden = true
                self?.makeLiveButton.isHidden = false
                self?.showSimpleAlert(message: statusChange?.message ?? DefaultValue.emptyString.rawValue)
            }else{
                self?.showSimpleAlert(message: statusChange?.message ?? DefaultValue.emptyString.rawValue)
            }
            
        }
        
    }
    
}
// MARK: - Create extension for date format
/// create function to convert time interval
extension EventDetailViewController{
    func convertTimerToHours(time:String) -> String{
        let dateAsString = time
        let dateFormatter = DateFormatter()
        dateFormatter.dateFormat = DefaultValue.outputTimeFormat.rawValue
        guard let date = dateFormatter.date(from: dateAsString) else {return "00:00"}
        let newDateFormatter = DateFormatter()
        newDateFormatter.dateFormat = DefaultValue.inputTimeFormat.rawValue
        let date24 = dateFormatter.string(from: date)
        return date24
    }
    
    // MARK: Create function for update time--
    ///create function for show the event description date and time
    @objc func UpdateTime() {
        let userCalendar = Calendar.current
        // Set Current Date
        let date = Date()
        let components = userCalendar.dateComponents([.day,.second, .minute, .hour], from: date)
        _ = userCalendar.date(from: components)!
        guard let eventStartDate = eventDetailModel.data?.event?.startDate else {return}
        let dateArray = eventStartDate.split(separator: "-")
        guard let eventStartTime = eventDetailModel.data?.event?.startTime else {return}
        let time24Hours =  convertTimerToHours(time:eventStartTime)
        let time24HoursArray = time24Hours.split(separator: ":")
        
        // Set Event Date
        var eventDateComponents = DateComponents()
        eventDateComponents.year = Int(dateArray[0]) ?? 0
        eventDateComponents.month = Int(dateArray[1]) ?? 0
        eventDateComponents.day = Int(dateArray[2]) ?? 0
        eventDateComponents.hour = Int(time24HoursArray[0]) ?? 0
        eventDateComponents.minute = Int(time24HoursArray[1]) ?? 0
        eventDateComponents.second = 00
        eventDateComponents.timeZone = TimeZone.autoupdatingCurrent
        // Convert eventDateComponents to the user's calendar
        let startDate = userCalendar.date(from: eventDateComponents)!
        // Change the seconds to days, hours, minutes and seconds
        let timeLeft = userCalendar.dateComponents([.day, .hour, .minute, .second], from: Date(), to: startDate)
        // Display Countdown
        if timeLeft.day ?? 0 > 0 || timeLeft.hour ?? 0 > 0 || timeLeft.minute ?? 0 > 0 || timeLeft.second ?? 0 > 0{
            lblEventStatus.text = "Event Starting in:- \(timeLeft.day!)d \(timeLeft.hour!)h \(timeLeft.minute!)m \(timeLeft.second!)s"
        } else if date <= self.getEndDate() {
            lblEventStatus.text = AppMessage.shared.EventRunning
            // Stop Timer
            timer.invalidate()
        } else {
            lblEventStatus.text = AppMessage.shared.EventExpired
            timer.invalidate()
        }
    }
   
    // MARK: Create function getting end time--
    ///create function for compare end date from current date and time
    func getEndDate() -> Date {
        let userCalendar = Calendar.current
        // Set Current Date
        let eventEndDate = eventDetailModel.data?.event?.endDate ?? DefaultValue.emptyString.rawValue
         let dateArray = eventEndDate.split(separator: "-")
        let eventEndTime = eventDetailModel.data?.event?.endTime ?? DefaultValue.emptyString.rawValue
        let time24Hours =  convertTimerToHours(time:eventEndTime)
        let time24HoursArray = time24Hours.split(separator: ":")
        // Set Event Date
        var eventDateComponents = DateComponents()
        eventDateComponents.year = Int(dateArray[0]) ?? 0
        eventDateComponents.month = Int(dateArray[1]) ?? 0
        eventDateComponents.day = Int(dateArray[2]) ?? 0
        eventDateComponents.hour = Int(time24HoursArray[0]) ?? 0
        eventDateComponents.minute = Int(time24HoursArray[1]) ?? 0
        eventDateComponents.second = 00
        eventDateComponents.timeZone = TimeZone.autoupdatingCurrent
        // Convert eventDateComponents to the user's calendar
        let endDate = userCalendar.date(from: eventDateComponents)!
     
        return endDate
    }
}
