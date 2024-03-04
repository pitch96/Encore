//
//  CreateEventViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 27/12/22.
//

import UIKit
import SDWebImage
import iOSDropDown

class CreateEventViewController: UIViewController{
    
    // MARK: @IBOUTLETS--
    @IBOutlet weak var startDateTextField: UITextField!
    @IBOutlet weak var eventTitleTextField: UITextField!
    @IBOutlet weak var categoryTextField: DropDown!
    @IBOutlet weak var organizerTextField: UITextField!
    @IBOutlet weak var viewStartDate: CustomView!
    @IBOutlet weak var viewUpload: GradientBackgroundView!
    @IBOutlet weak var endDateTextField: UITextField!
    @IBOutlet weak var startTimeTextField: UITextField!
    @IBOutlet weak var endTimeTextField: UITextField!
    @IBOutlet weak var venueTextField: UITextField!
    @IBOutlet weak var addressTextField: UITextField!
    @IBOutlet weak var cityTextField: UITextField!
    @IBOutlet weak var zipCodeTextField: UITextField!
    @IBOutlet weak var descriptionTextView: UITextView!
    @IBOutlet weak var uploadtextField: UITextField!
   
    
    // MARK: Variable Initialization--
    var imagePicker: ImagePicker!
    lazy var createEventViewModel:CreateEventViewModel = {
        var createEventViewModel = CreateEventViewModel()
        return createEventViewModel
    }()
    var createEventModel : CreateEventModel?
    var getList : [ManagecategoryDetail]?
    var categoryID : Int?
    var picker = UIDatePicker()
    var toolBar = UIToolbar()
    var formatter = DateFormatter()
    
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        
        descriptionTextView.delegate = self
        descriptionTextView.text = DefaultValue.description.rawValue
        descriptionTextView.textColor = UIColor.lightGray
        self.imagePicker = ImagePicker(presentationController: self, delegate: self)
        categoryTextField.delegate = self
        categoryTextField.isUserInteractionEnabled = true
        categoryTextField.didSelect{[weak self](selectedText , index ,id) in
            self?.categoryTextField.text = selectedText
            self?.categoryID = self?.getList?[index].id ?? 0
            
        }
        // Do any additional setup after loading the view.
        viewUpload.layer.maskedCorners = [.layerMaxXMaxYCorner, .layerMaxXMinYCorner]
        startDateTextField.delegate = self
        endDateTextField.delegate = self
        startTimeTextField.delegate = self
        endTimeTextField.delegate = self
        zipCodeTextField.delegate = self
        uploadtextField.isUserInteractionEnabled = false
        getCategoryList()
    }
    
    // MARK: create function for get category list
    func getCategoryList(){
        createEventViewModel.callgetCategoryListApi {[weak self] getCtegoryList, IsSuccess in
            if IsSuccess == true{
                self?.getList = getCtegoryList.data
                if let nameList = self?.getList?.map({$0.name}) as? [String] {
                    self?.categoryTextField.optionArray = nameList
                }
                
            }else{
                self?.showSimpleAlert(message: getCtegoryList.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    
    // MARK: - Cancel Button Action
    /// Create Function For not
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func cancelButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
        
    }
    // MARK: Create Event Api Call--
    /// Create Function For Calling Create Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func saveEventButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            createEvent()
        }
    }
    
    // MARK: Create function for calling create event APi--
    func createEvent(){
        createEventViewModel.callCreateEventApi(id: categoryID ?? 0, eventTitle: eventTitleTextField.text ?? DefaultValue.emptyString.rawValue, organizer: organizerTextField.text ?? DefaultValue.emptyString.rawValue, venue: venueTextField.text ?? DefaultValue.emptyString.rawValue, address: addressTextField.text ?? DefaultValue.emptyString.rawValue, city: cityTextField.text ?? DefaultValue.emptyString.rawValue, zipcode: zipCodeTextField.text ?? DefaultValue.emptyString.rawValue, startDate: startDateTextField.text ?? DefaultValue.emptyString.rawValue, endDate: endDateTextField.text ?? DefaultValue.emptyString.rawValue, startTime: startTimeTextField.text ?? DefaultValue.emptyString.rawValue, endTime: endTimeTextField.text ?? DefaultValue.emptyString.rawValue, description: descriptionTextView.text,image: self.createEventViewModel.media.first?.filename ?? DefaultValue.emptyString.rawValue, file: self.createEventViewModel.media ) {[weak self] CreateEventData, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: CreateEventData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    //self?.navigationController?.pushViewController(ManageEventViewController, animated: true)
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
                self?.createEventViewModel.media.removeAll()
            }else{
                self?.showSimpleAlert(message: CreateEventData?.message ?? DefaultValue.emptyString.rawValue)
            }
        }
    }
    
    // MARK: Change the Status Bar Color--
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    
    // MARK: Create a function for back to controller--
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    
    // MARK: Create a function for time picker--
    func showTimePicker(textfield: UITextField) {
        let screenWidth = UIScreen.main.bounds.width
        //Add DatePicker as inputView
        self.picker = UIDatePicker(frame: CGRect(x: 0, y: 0, width: screenWidth, height: 200))
        switch textfield {
        case startTimeTextField:
            picker.datePickerMode = .time
        case endTimeTextField:
            picker.datePickerMode = .time
        case startDateTextField:
            picker.datePickerMode = .date
            picker.minimumDate = Date()
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
        let cancelBarButton = UIBarButtonItem(title: Alert.cancelTitle, style: .plain, target: self, action: #selector(cancelPressed))
        let doneBarButton = UIBarButtonItem(title: DefaultValue.done.rawValue, style: .plain, target: self, action: #selector(doneButtonTapped))
        self.toolBar.setItems([cancelBarButton, flexibleSpace, doneBarButton], animated: false)
        textfield.inputAccessoryView = toolBar
    }
    
    @objc func doneButtonTapped() {
        if startDateTextField.isFirstResponder {
            formatter.dateFormat = DefaultValue.inputDateFormat.rawValue
            startDateTextField.text = formatter.string(from: picker.date)
        }
        if endDateTextField.isFirstResponder {
            formatter.dateFormat = DefaultValue.inputDateFormat.rawValue
            endDateTextField.text = formatter.string(from: picker.date)
        }
        if startTimeTextField.isFirstResponder {
            formatter.dateFormat = DefaultValue.outputTimeFormat.rawValue
            startTimeTextField.text = formatter.string(from: picker.date)
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
    
    
    // MARK: Upload Image Button Action--
    /// Create Function for select a image from gallary and Camera
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func uploadImageButtonAction(_ sender: UIButton) {
        self.imagePicker.present(from: sender)
    }
    
    
    // MARK: TextFields Validation--
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation()-> String?{
        guard !(String.getString(self.eventTitleTextField.text).isEmpty) else{return AppMessage.shared.EventTitle}
        guard !(String.getString(self.categoryTextField.text).isEmpty) else{return AppMessage.shared.EventCategory}
        guard !(String.getString(self.organizerTextField.text).isEmpty) else{return AppMessage.shared.EventOrganizer}
        guard !(String.getString(self.startDateTextField.text).isEmpty) else{return AppMessage.shared.EventStartDate}
        guard !(String.getString(self.endDateTextField.text).isEmpty) else{return AppMessage.shared.EventEndDate}
        guard !(String.getString(self.startTimeTextField.text).isEmpty) else{return AppMessage.shared.EventStartTime}
        guard !(String.getString(self.endTimeTextField.text).isEmpty) else{return AppMessage.shared.EventEndTime}
        guard !(String.getString(self.venueTextField.text).isEmpty) else{return AppMessage.shared.EventVenue}
        guard !(String.getString(self.addressTextField.text).isEmpty) else{return AppMessage.shared.EventAddress}
        guard !(String.getString(self.cityTextField.text).isEmpty) else{return AppMessage.shared.EventCity}
        guard !(String.getString(self.zipCodeTextField.text).isEmpty) else{return AppMessage.shared.EventZipCode}
        guard !(String.getString(self.descriptionTextView.text).isEmpty) else{return AppMessage.shared.EventDescription}
        return nil
        
    }
}
///Create function for set the maximum character in textfield
/// - Parameter textField: UITextField
extension CreateEventViewController : UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case zipCodeTextField:
            guard let textFieldText = zipCodeTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 6
        case organizerTextField:
            guard let textFieldText = organizerTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 27
        case cityTextField:
            guard let textFieldText = cityTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 20
        default:
            return true
        }
        
    }
    
    func textFieldDidBeginEditing(_ textField: UITextField) {
        if textField == startDateTextField {
            picker.datePickerMode = .date
            self.showTimePicker(textfield: textField)
        }
        if textField == endDateTextField {
            picker.datePickerMode = .date
            self.showTimePicker(textfield: textField)
        }
        if textField == startTimeTextField {
            picker.datePickerMode = .time
            self.showTimePicker(textfield: textField)
        }
        if textField == endTimeTextField {
            self.showTimePicker(textfield: textField)
        }
        }
    // MARK: - Create function for avoid interaction form textfield
        func textFieldShouldBeginEditing(_ textField: UITextField) -> Bool
        {
            switch textField {
            case categoryTextField:
                return false
            default:
                return true
            }
        }
    
}
// MARK: Extension for image picker delegate
extension CreateEventViewController: ImagePickerDelegate {
    func didSelectImage(image: UIImage?, imageName: String) {
        self.uploadtextField.text = imageName
        guard let imageData = Media(withImage: image ?? UIImage(), forKey: DefaultValue.image.rawValue) else {return}
        createEventViewModel.media.append(imageData)
    }
    
}
extension CreateEventViewController: UITextViewDelegate{
    func textViewDidBeginEditing(_ textView: UITextView) {
        if textView.textColor == UIColor.lightGray {
            textView.text = nil
            textView.textColor = UIColor.white
        }
    }
}
