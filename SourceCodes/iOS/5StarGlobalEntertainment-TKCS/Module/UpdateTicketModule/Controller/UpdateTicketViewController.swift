//
//  UpdateTicketViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/02/23.
//

import UIKit
import iOSDropDown

class UpdateTicketViewController: UIViewController {
    // MARK: IBoutlets
    @IBOutlet weak var eventTextField: UITextField!
    @IBOutlet weak var titleTicket: UITextField!
    @IBOutlet weak var ticketType: DropDown!
    @IBOutlet weak var ticketQuantity: UITextField!
    @IBOutlet weak var endDateTextField: UITextField!
    @IBOutlet weak var endTimeTextField: UITextField!
    @IBOutlet weak var priceTextField: UITextField!
    @IBOutlet weak var viewPrice: CustomView!
    var eventEndDate:Date?
    var selectedEventEndDate:Date?
    
    // MARK: Variable Initializer--
    var updateTicketModel : UpdateTicketModel?
    lazy var updateTicketViewModel:UpdateTicketViewModel = {
        var updateTicketViewModel = UpdateTicketViewModel()
        return updateTicketViewModel
    }()
    var update = UpdateEventViewModel()
    var ticket : ticketDetails?
    var ticketTypeList = ["Free", "Paid"]
    var picker = UIDatePicker()
    var toolBar = UIToolbar()
    var formatter = DateFormatter()
    var eventID = Int()
    
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        ticketQuantity.delegate = self
        priceTextField.delegate = self
        endDateTextField.delegate = self
        ticketType.delegate = self
        endTimeTextField.delegate = self
        eventTextField.delegate = self
        viewPrice.isHidden = true
        ticketType.optionArray = ticketTypeList
        ticketType.isUserInteractionEnabled = true
        ticketType.didSelect{[weak self](selectedText , index ,id) in
            //self?.eventTextField.text = selectedText
            if selectedText == DefaultValue.Free.rawValue{
                self?.viewPrice.isHidden = true
                self?.priceTextField.text = "0"
            }else{
                self?.viewPrice.isHidden = false
            }
        }
        getTicketAPiCall()
    }
   
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Create function for call get ticket detail api--
    func getTicketAPiCall(){
        updateTicketViewModel.callgetTicketApi(id:updateTicketViewModel.id ) {[weak self] data, isSuccess in
            if isSuccess == true{
                if data?.data?.ticket?.price ?? 0 > 0 {
                    self?.viewPrice.isHidden = false
                }else{
                    self?.viewPrice.isHidden = true
                }
                self?.eventTextField.text = self?.updateTicketViewModel.eventTitle.capitalized
                self?.titleTicket.text = data?.data?.ticket?.ticketTitle
                self?.ticketType.text = data?.data?.ticket?.ticketType
                self?.ticketQuantity.text = "\(data?.data?.ticket?.quantity ?? 0)"
                self?.endDateTextField.text = data?.data?.ticket?.endDate
                self?.endTimeTextField.text = data?.data?.ticket?.endTime
                self?.priceTextField.text = "$\(data?.data?.ticket?.price ?? 0)"
                if let endDate = data?.data?.ticket?.endDate{
                self?.eventEndDate = self?.convertStringToDate(date: endDate)
                    }}
        }}
    // MARK: create function for Update Ticket--
    func updateTicket(){
        
        let priceInStringValue = priceTextField.text?.replacingOccurrences(of: "$", with: "", options: NSString.CompareOptions.literal, range: nil)
        
        updateTicketViewModel.callUpdateTicketApi(eventId: eventID , ticketTitle: titleTicket.text ?? DefaultValue.emptyString.rawValue, ticketType: ticketType.text ?? DefaultValue.emptyString.rawValue, ticketQty: ticketQuantity.text ?? DefaultValue.emptyString.rawValue, ticketPrice: priceInStringValue ?? DefaultValue.emptyString.rawValue, endDate: endDateTextField.text ?? DefaultValue.emptyString.rawValue, endTime: endTimeTextField.text ?? DefaultValue.emptyString.rawValue) {[weak self] updateData, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: updateData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                self?.showSimpleAlert(message: updateData?.message ?? DefaultValue.errorMsg.rawValue)
            }}}
    // MARK: Cancel Button Action--
    /// Create Function For Navigate to Home View Controller
    /// - Parameter sender : UIButton
    @IBAction func cancelButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }

    // MARK: Create a function for time picker--
    func showTimePicker(textfield: UITextField) {
        let screenWidth = UIScreen.main.bounds.width
           //Add DatePicker as inputView
        self.picker = UIDatePicker(frame: CGRect(x: 0, y: 0, width: screenWidth, height: 200))
        switch textfield {
        case endTimeTextField:
            picker.datePickerMode = .time
        case endDateTextField:
            picker.datePickerMode = .date
//            picker.minimumDate = Date()
        default:
            break
        }

        if #available(iOS 13.4, *) {
        picker.preferredDatePickerStyle = .wheels
            } else {
            // Fallback on earlier versions
            }
           textfield.inputView = picker

           //Add Tool Bar as input AccessoryView
           self.toolBar = UIToolbar(frame: CGRect(x: 0, y: 0, width: screenWidth, height: 44))
           let flexibleSpace = UIBarButtonItem(barButtonSystemItem: .flexibleSpace, target: nil, action: nil)
        let cancelBarButton = UIBarButtonItem(title: Alert.cancelTitle, style: .plain, target: self, action: #selector(cancelPressed))
        let doneBarButton = UIBarButtonItem(title: DefaultValue.done.rawValue, style: .plain, target: self, action: #selector(doneButtonTapped))
           self.toolBar.setItems([cancelBarButton, flexibleSpace, doneBarButton], animated: false)
           textfield.inputAccessoryView = toolBar
    }
    
    @objc func doneButtonTapped() {
        if endDateTextField.isFirstResponder {
            formatter.dateFormat = DefaultValue.inputDateFormat.rawValue
            endDateTextField.text = formatter.string(from: picker.date)
        }
        if endTimeTextField.isFirstResponder {
            formatter.dateFormat = DefaultValue.outputTimeFormat.rawValue
            endTimeTextField.text = formatter.string(from: picker.date)
        }
        self.view.endEditing(true)
    }
        
    @objc func cancelPressed() {
        view.endEditing(true)
      }
  
    // MARK: update Ticket Api call--
    /// Create Function For calling update ticket api
    /// - Parameter sender : UIButton
    @IBAction func updateButtonAction(_ sender: Any) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            updateTicket()
        }
    }
    // MARK: TextFields Validation--
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation()-> String?{
        if ticketType.text == DefaultValue.Free.rawValue{
            guard !(String.getString(self.titleTicket.text).isEmpty) else{return AppMessage.shared.EnterTicketTitle}
            guard !(String.getString(self.ticketType.text).isEmpty) else{return AppMessage.shared.EnterTicketType}
            guard !(String.getString(self.ticketQuantity.text).isEmpty) else{return AppMessage.shared.EnterTicketQuantity}
            guard !(String.getString(self.endDateTextField.text).isEmpty) else{return AppMessage.shared.EnterEndDate}
            if let endDate =  selectedEventEndDate{
                if (endDate) > (eventEndDate ?? Date()) {
                    return AppMessage.shared.EnterValidEndDate
                }
            }
            guard !(String.getString(self.endTimeTextField.text).isEmpty) else{return AppMessage.shared.EnterEndTime}
        }else{
            guard !(String.getString(self.titleTicket.text).isEmpty) else{return AppMessage.shared.EnterTicketTitle}
            guard !(String.getString(self.ticketType.text).isEmpty) else{return AppMessage.shared.EnterTicketType}
            guard !(String.getString(self.ticketQuantity.text).isEmpty) else{return AppMessage.shared.EnterTicketQuantity}
            guard !(String.getString(self.endDateTextField.text).isEmpty) else{return AppMessage.shared.EnterEndDate}
            if let endDate =  selectedEventEndDate{
                if (endDate) > (eventEndDate ?? Date()) {
                    return AppMessage.shared.EnterValidEndDate
                }
            }
            guard !(String.getString(self.endTimeTextField.text).isEmpty) else{return AppMessage.shared.EnterEndTime}
            guard !(String.getString(self.priceTextField.text).isEmpty) else{return AppMessage.shared.EnterPrice}
            guard (self.priceTextField.text != "0") else {return AppMessage.shared.EnterValidPrice}
            return nil
        }
        return nil
    }
    
    // MARK: Navigate To Manage ticket view controller--
    /// Create Function For Navigate to  manage ticket view controller
    /// - Parameter sender : UIButton
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
}
extension UpdateTicketViewController: UITextFieldDelegate{
    // MARK: Delegate for textfields--
    ///Create function for set the maximum character in textfield
    /// - Parameter textField: UITextField
    func textFieldShouldBeginEditing(_ textField: UITextField) -> Bool
    {
        switch textField {
        case endTimeTextField:
            //self.getTimePicker()
            showTimePicker(textfield: endTimeTextField)
            return true
        case endDateTextField:
           // self.openDatePicker(textField: endDateTextField)
            showTimePicker(textfield: endTimeTextField)
            return true
        case eventTextField:
            return false
        case ticketType:
            return false
        default:
            return true
        }
    }
    ///Create function for set the maximum character in textfield--
    /// - Parameter textField: UITextField
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case priceTextField:
            guard let textFieldText = priceTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 9
            
        case ticketQuantity:
            guard let textFieldText = ticketQuantity.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 9
//            return false
        case titleTicket:
            guard let textFieldText = titleTicket.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 9
        default:
            return true
        }}
    func textFieldDidBeginEditing(_ textField: UITextField) {
            if textField == endDateTextField {
                picker.datePickerMode = .date
                self.showTimePicker(textfield: textField)
            }
            if textField == endTimeTextField {
                self.showTimePicker(textfield: textField)
            }
        }
}
// MARK: Extension for date picker
extension UpdateTicketViewController{
    // MARK: Create funtion for  Convert date--
    func convertStringToDate(date:String)->Date?{
        let dateFormatter = DateFormatter()
        dateFormatter.locale = Locale(identifier: DefaultValue.Locale.rawValue) // set locale to reliable US_POSIX
        dateFormatter.dateFormat = DefaultValue.inputDateFormat.rawValue
        let newDate = dateFormatter.date(from:date)
        return newDate
        
    }
}
