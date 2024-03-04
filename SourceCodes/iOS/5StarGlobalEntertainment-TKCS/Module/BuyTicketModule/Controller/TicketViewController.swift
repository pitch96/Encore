//
//  TicketViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/12/22.
//

import UIKit
import SDWebImage
import iOSDropDown

class TicketViewController: UIViewController {
    //UserInterface
    // MARK: @IBOutlets
    @IBOutlet weak var ticketType: DropDown!
    @IBOutlet weak var imageEvent: UIImageView!
    @IBOutlet weak var lblStartDate: UILabel!
    @IBOutlet weak var lblStartTime: UILabel!
    @IBOutlet weak var lblEndDate: UILabel!
    @IBOutlet weak var lblEndTime: UILabel!
    @IBOutlet weak var lblPerheadPrice: UILabel!
    @IBOutlet weak var lblTotalPrice: UILabel!
    @IBOutlet weak var btnDecrease: UIButton!
    @IBOutlet weak var btnIncrease: UIButton!
    @IBOutlet weak var lableShowQuantity: UILabel!
    @IBOutlet weak var lblEventDescription: UILabel!
    @IBOutlet weak var lblEventAddress: UILabel!
    @IBOutlet weak var lblEventTitle: UILabel!
    // MARK: Variable Initialization
    var ticketViewModel = TicketViewModel()
    var ticketID :Int = 0
    var ticket = TicketModel()
    var count = 1
    var selectedTicketID:Int?
    var selectedTicketPrice = 0.0
    var userToken = UserDefaults.standard.string(forKey: Tokenkey.UsersTypes)
    var remainingTicketQuantity = 0
    
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        ticketType.delegate = self
        ticketType.isUserInteractionEnabled = true
        ticketType.didSelect{(selectedText , index ,id) in
            self.count = 1
            if selectedText != "---Select---" {
                self.ticketType.text = selectedText
                self.selectedTicketID = id
                self.selectedTicketPrice = Double(self.ticket.data?.tickets?[index].price ?? 0)
                self.lblPerheadPrice.text = String("$ \(self.selectedTicketPrice)")
                self.remainingTicketQuantity = self.ticket.data?.tickets?[index].quantity ?? 0
                self.updateTotalPrice()
            } else {
                debugPrint("no ticket found")
            }
        }
        // Do any additional setup after loading the view.
        btnIncrease.addTarget(self, action: #selector(increase(_:)), for: .touchUpInside)
        btnDecrease.addTarget(self, action: #selector(decrease(_:)), for: .touchUpInside)
    //    getTicketDetailApi()
    }
    
    override func viewWillAppear(_ animated: Bool) {
        getTicketDetailApi()
    }
    // MARK: Ticket API Call
    /// Create Function For Calling Ticket Api
    /// - Parameter sender: nil
    /// return : nil
    func getTicketDetailApi(){
        ticketViewModel.CallTicketApi(eventId: ticketID) {[weak self] ticketData, isSuccess in
            if ticketData.success == true{
                self?.ticket = ticketData
                DispatchQueue.main.async {
                    self?.lblEventAddress.text = "\(ticketData.data?.event?.venue ?? DefaultValue.emptyString.rawValue), \(ticketData.data?.event?.address ?? DefaultValue.emptyString.rawValue), \(ticketData.data?.event?.city ?? DefaultValue.emptyString.rawValue), \(ticketData.data?.event?.zipcode ?? DefaultValue.emptyString.rawValue)"
                    self?.lblEventDescription.text = ticketData.data?.event?.eventDescription
                    self?.lblEventTitle.text = ticketData.data?.event?.eventTitle?.capitalized
                    self?.lblEndDate.text = Common.shared.dateConvertor(inputFormat:DefaultValue.inputDateFormat.rawValue, outputFormat:DefaultValue.outputDateFormat.rawValue, dateString: ticketData.data?.event?.endDate ?? DefaultValue.emptyString.rawValue)
                    self?.lblStartDate.text = Common.shared.dateConvertor(inputFormat: DefaultValue.inputDateFormat.rawValue, outputFormat: DefaultValue.outputDateFormat.rawValue, dateString: ticketData.data?.event?.startDate ?? DefaultValue.emptyString.rawValue)
                    self?.lblStartTime.text =  Common.shared.dateConvertor(inputFormat: DefaultValue.inputTimeFormat.rawValue , outputFormat: DefaultValue.outputTimeFormat.rawValue, dateString: ticketData.data?.event?.startTime ?? DefaultValue.emptyString.rawValue)
                    self?.lblEndTime.text = Common.shared.dateConvertor(inputFormat: DefaultValue.inputTimeFormat.rawValue, outputFormat: DefaultValue.outputTimeFormat.rawValue, dateString: ticketData.data?.event?.endTime ?? DefaultValue.emptyString.rawValue)
                    let imageUrl = ticketData.data?.event?.image
                    let urlString = imageUrl?.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    // MARK: INDICATOR--
                    self?.imageEvent.sd_imageIndicator = SDWebImageActivityIndicator.gray
                    self?.imageEvent.sd_setImage(with: URL(string: urlString ))
                    self?.imageEvent.contentMode = .scaleToFill
                    var option = [String]()
                    var ticketID = [Int]()
                    for i in 0..<(ticketData.data?.tickets?.count ?? 0){
                        option.append(ticketData.data?.tickets?[i].ticketTitle ?? DefaultValue.emptyString.rawValue)
                        ticketID.append(ticketData.data?.tickets?[i].id ?? 0)
                    }
                    if option.count > 0 {
                        self?.ticketType.optionArray = option
                    } else {
                        self?.ticketType.optionArray.append("---Select---")
                    }
                    if ticketID.count > 0 {
                        self?.ticketType.optionIds = ticketID
                    }
                }
            }else{
            }
        }
    }
    
    // MARK: create function for change the status bar color--
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Function for Decrease Button Action
    /// Create Function For decrease the value and show in label
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func decrease(_ sender:UIButton){
        if ticketType.text != DefaultValue.select.rawValue{
            if count <= 1{
                count = 1
            }else{
                count -= 1
                updateTotalPrice()
            }
        }else{
            self.showSimpleAlert(message: AppMessage.shared.SelectTicket)
        }
    }
    // MARK: Function for Increase Button Action
    /// Create Function For increase the value and show in label
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func increase(_ sender:UIButton){
        if ticketType.text != DefaultValue.select.rawValue{
            self.lableShowQuantity.text = String(count)
            debugPrint(remainingTicketQuantity)
            debugPrint(count)
            
            if remainingTicketQuantity >= (count) {
                if count != remainingTicketQuantity{
                    count += 1
                    updateTotalPrice()
                }else{
                    self.showSimpleAlert(message: AppMessage.shared.NoMoreticket)
                }
            }else{
                self.showSimpleAlert(message: AppMessage.shared.NoMoreticket)
            }
        }else{
            self.showSimpleAlert(message: AppMessage.shared.SelectTicket)
        }
        
    }
    // MARK: Create function for total price--
    func updateTotalPrice(){
        self.lableShowQuantity.text = String(count)
        debugPrint("$ \(Double(count) * (ticket.data?.tickets?[0].price ?? 0.0))")
        self.lblTotalPrice.text = "$ \(((Double(count) ) * (selectedTicketPrice )))"
        
    }
    // MARK: Button action Buy ticket
    /// Create Function For buy Ticket
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func btnBuyTicket(_ sender: UIButton) {
        if ticketType.text == DefaultValue.select.rawValue{
           
            showSimpleAlert(message: AppMessage.shared.SelectTicket)
        }else if(userToken == DefaultValue.defaultUser.rawValue){
            moveToLogin()
        }
        else if ticket.data?.tickets?.first?.quantity ?? 0 < 0{
            self.showSimpleAlert(message: AppMessage.shared.NoMoreticket)
        }
        else{
            addToCartApiCalling()
        }
        
    }
    // MARK: Back Button Action--
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func buttonBcak(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Create a function for calling AddToCart APi--
    private func addToCartApiCalling(){
        ticketViewModel.callAddToCartApi(ticketID: selectedTicketID ?? 0, quantity: Int(lableShowQuantity.text ?? "0") ?? 0) {[weak self] cartData, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: cartData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                    self?.tabBarController?.selectedIndex = 2
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                // self.showSimpleAlert(message: cartData?.message ?? DefaultValue.emptyString.rawValue)
            }
        }
    }
    // MARK: Create a function for navigate to login iew Controller--
    private func moveToLogin(){
        let alert = UIAlertController(title: DefaultValue.emptyString.rawValue, message:DefaultValue.loginFirst.rawValue, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: DefaultValue.login.rawValue, style: UIAlertAction.Style.default, handler:{ action in
            UserDefaults.standard.setValue( DefaultValue.emptyString.rawValue, forKey: Tokenkey.userLogin)
            AppDelegate.sharedInstance.showLogin()
        }))
        alert.addAction(UIAlertAction(title: DefaultValue.cancel.rawValue, style: UIAlertAction.Style.cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
        
    }
    
}
// MARK: create extension for textfield delegate--
///create a function for textfiled not be edited
///return:UITextField
extension TicketViewController: UITextFieldDelegate {
    func textFieldShouldBeginEditing(_ textField: UITextField) -> Bool
    {
        switch textField {
        case ticketType:
            return false
        default:
            return true
        }
    }
}
