//
//  CreateTicketTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 07/01/23.
//

import UIKit
import iOSDropDown

class CreateTicketTableViewCell: UITableViewCell, UITextFieldDelegate {
    // MARK: IBOutlets--
    @IBOutlet weak var titleTextField: UITextField!
    @IBOutlet weak var ticketTypeTextField: DropDown!
    @IBOutlet weak var quantityTextField: UITextField!
    @IBOutlet weak var endDateTextField: UITextField!
    @IBOutlet weak var endTimeTextField: UITextField!
    @IBOutlet weak var minusButton: UIButton!
    @IBOutlet weak var priceTextField: UITextField!
    @IBOutlet weak var viewPrice: CustomView!
    // MARK: Variable Initializer--
    var selectedTicketID:Int?
    let datePicker = UIDatePicker()
    var createTicketVC :CreateTicketViewController?
    var indexPath = 0
    var ticketTypeList = ["Free", "Paid"]
    var picker = UIDatePicker()
    var toolBar = UIToolbar()
    var formatter = DateFormatter()
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
        
        ticketTypeTextField.delegate = self
        viewPrice.isHidden = true
        ticketTypeTextField.isUserInteractionEnabled = true
        ticketTypeTextField.optionArray = ticketTypeList
        ticketTypeTextField.didSelect{(selectedText , index ,id) in
            self.ticketTypeTextField.text = selectedText
            self.selectedTicketID = id
            CreateTicketViewController.createdTicketList[self.indexPath].ticketType = self.ticketTypeList[index]
            if selectedText == "Free"{
                self.viewPrice.isHidden = true
                CreateTicketViewController.createdTicketList[self.indexPath].ticketPrice = nil
            }else{
                self.viewPrice.isHidden = false
            }
        }
        
        minusButton.isHidden = true
        endDateTextField.delegate = self
        endTimeTextField.delegate = self
        priceTextField.delegate = self
        quantityTextField.delegate = self
    }
    
    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)
        
        // Configure the view for the selected state
    }
    @IBAction func ticketTitleAction(_ sender: UITextField) {
        CreateTicketViewController.createdTicketList[indexPath].ticketTitle = sender.text ?? DefaultValue.emptyString.rawValue
    }
    @IBAction func quantityTxtAction(_ sender: UITextField) {
        CreateTicketViewController.createdTicketList[indexPath].ticketQty = sender.text ?? DefaultValue.emptyString.rawValue
    }
    
    @IBAction func priceTxtAction(_ sender: UITextField) {
        CreateTicketViewController.createdTicketList[indexPath].ticketPrice = Double(sender.text ?? "0.0")
    }
    
    @IBAction func endDateTxtAction(_ sender: UITextField) {
        self.showTimePicker(textfield: sender)
    }
    
    @IBAction func endTimeTxtAction(_ sender: UITextField) {
        self.showTimePicker(textfield: sender)
    }
    
   // MARK: create function for time picker and date picker--
    func textFieldDidBeginEditing(_ textField: UITextField) {
        if textField.tag == 2{
            self.showTimePicker(textfield: textField)
        }else if textField.tag == 1{
            self.showTimePicker(textfield: textField)
        }
    }
    // MARK: show Time Picker--
    func showTimePicker(textfield: UITextField) {
        let screenWidth = UIScreen.main.bounds.width
        //Add DatePicker as inputView
        self.picker = UIDatePicker(frame: CGRect(x: 0, y: 0, width: screenWidth, height: 200))
        switch textfield {
        case endTimeTextField:
            picker.datePickerMode = .time

        case endDateTextField:
            picker.datePickerMode = .date
            picker.minimumDate = Date()
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
        let cancelBarButton = UIBarButtonItem(title: DefaultValue.cancel.rawValue, style: .plain, target: self, action: #selector(cancelPressed))
        let doneBarButton = UIBarButtonItem(title: DefaultValue.done.rawValue, style: .plain, target: self, action: #selector(doneButtonTapped))
        self.toolBar.setItems([cancelBarButton, flexibleSpace, doneBarButton], animated: false)
        textfield.inputAccessoryView = toolBar
    }
    
    @objc func doneButtonTapped() {
        if endDateTextField.isFirstResponder {
            formatter.dateFormat = DefaultValue.inputDateFormat.rawValue
            formatter.timeZone = TimeZone.autoupdatingCurrent
            endDateTextField.text = formatter.string(from: picker.date)
            CreateTicketViewController.createdTicketList[self.indexPath].endDate = formatter.string(from: picker.date)
        }
        if endTimeTextField.isFirstResponder {
            formatter.dateFormat = DefaultValue.outputTimeFormat.rawValue
            formatter.timeZone = TimeZone.autoupdatingCurrent
            endTimeTextField.text = formatter.string(from: picker.date)
            CreateTicketViewController.createdTicketList[indexPath].endTime = formatter.string(from: picker.date)
           
        }
        createTicketVC?.view.endEditing(true)
    }
    
    @objc func cancelPressed() {
        createTicketVC?.view.endEditing(true)
    }
    }
///Create function for set the maximum character in textfield
/// - Parameter textField: UITextField
extension CreateTicketTableViewCell{
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
            
        case quantityTextField:
            guard let textFieldText = quantityTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 9
        default:
            return true
        }
    }
}
