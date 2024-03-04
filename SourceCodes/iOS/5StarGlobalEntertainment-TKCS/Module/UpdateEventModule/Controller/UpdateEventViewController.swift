//
//  UpdateEventViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 08/02/23.
//

import UIKit
import iOSDropDown

class UpdateEventViewController: UIViewController, UIImagePickerControllerDelegate & UINavigationControllerDelegate {
    // MARK: IBOutlets--
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
    
    // MARK: Variable Initializer--
    var imagePicker = UIImagePickerController()
    lazy var updateEventViewModel:UpdateEventViewModel = {
        var updateEventViewModel = UpdateEventViewModel()
        return updateEventViewModel
    }()
    var updateEventModel : UpdateEventModel?
    var categoryID : Int?
    var eventID : Int?
    var getList : [ManagecategoryDetail]?
    
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        imagePicker.delegate = self
        categoryTextField.delegate = self
        categoryTextField.isUserInteractionEnabled = true
        categoryTextField.didSelect{(selectedText , index ,id) in
            self.categoryTextField.text = selectedText
            self.categoryID = self.getList?[index].id ?? 0
        }
        // Do any additional setup after loading the view.
        viewUpload.layer.maskedCorners = [.layerMaxXMaxYCorner, .layerMaxXMinYCorner]
        startTimeTextField.delegate = self
        endTimeTextField.delegate = self
        startDateTextField.delegate = self
        endDateTextField.delegate = self
        zipCodeTextField.delegate = self
        uploadtextField.isUserInteractionEnabled = false
        // Do any additional setup after loading the view.
        updateEventViewModel.callgetEventCategoryListApi {[weak self] getCategoryList, isSuccess in
            if isSuccess == true{
                self?.getList = getCategoryList.data
                if let nameList = self?.getList?.map({$0.name}) as? [String] {
                    self?.categoryTextField.optionArray = nameList
                }
                let selectedCategory = self?.getList?.filter({$0.id == self?.categoryID})
                self?.categoryTextField.text = selectedCategory?.first?.name ?? DefaultValue.emptyString.rawValue
            }
            else{
                self?.showSimpleAlert(message: getCategoryList.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: viewWillAppear--
    /// create function for calling get Event API Call
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        getEventApiCall()
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: create function for show Image Picker--
    func showImagePicker(){
        let alert = UIAlertController(title: AppMessage.shared.ChooseLibrary, message: nil, preferredStyle: .actionSheet)
        alert.addAction(UIAlertAction(title: AppMessage.shared.Camera, style: .default, handler: { _ in
            self.openCamera()
        }))
        alert.addAction(UIAlertAction(title: AppMessage.shared.Gallary, style: .default, handler: { _ in
            self.openGallary()
        }))
        alert.addAction(UIAlertAction.init(title: DefaultValue.cancel.rawValue, style: .cancel, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    // MARK: Create function for open Camera--
    func openCamera(){
        if(UIImagePickerController .isSourceTypeAvailable(UIImagePickerController.SourceType.camera)){
            imagePicker.sourceType = UIImagePickerController.SourceType.camera
            imagePicker.allowsEditing = true
            self.present(imagePicker, animated: true, completion: nil)}
        else{
            let alert  = UIAlertController(title: AppMessage.shared.Warning, message: AppMessage.shared.CameraWarning, preferredStyle: .alert)
            alert.addAction(UIAlertAction(title: DefaultValue.ok.rawValue, style: .default, handler: nil))
            self.present(alert, animated: true, completion: nil)
        }}
    // MARK: Create function for open Gallary--
    func openGallary(){
        imagePicker.sourceType = UIImagePickerController.SourceType.photoLibrary
        imagePicker.allowsEditing = true
        self.present(imagePicker, animated: true, completion: nil)}
    
    // MARK: create function for calling Update Event api--
    func callUpdateEventApi(){
        updateEventViewModel.callUpdateEventApi(eventId: updateEventModel?.data?.id ,categoryId: categoryID, eventTitle: eventTitleTextField.text ?? DefaultValue.emptyString.rawValue, organizer: organizerTextField.text ?? DefaultValue.emptyString.rawValue, venue: venueTextField.text ?? DefaultValue.emptyString.rawValue, address: addressTextField.text ?? DefaultValue.emptyString.rawValue, city: cityTextField.text ?? DefaultValue.emptyString.rawValue, zipcode: zipCodeTextField.text ?? DefaultValue.emptyString.rawValue, startDate: startDateTextField.text ?? DefaultValue.emptyString.rawValue, endDate: endDateTextField.text ?? DefaultValue.emptyString.rawValue, startTime: startTimeTextField.text ?? DefaultValue.emptyString.rawValue, endTime: endTimeTextField.text ?? DefaultValue.emptyString.rawValue, description: descriptionTextView.text,image: self.updateEventViewModel.media.first?.filename ?? DefaultValue.emptyString.rawValue, file: self.updateEventViewModel.media) {[weak self] updateEventDatail, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: updateEventDatail?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.updateEventViewModel.media.removeAll()
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                self?.showSimpleAlert(message: updateEventDatail?.message ?? DefaultValue.errorMsg.rawValue)
            }}
    }
    // MARK: Create function for calling get event Api--
    func getEventApiCall(){
        updateEventViewModel.callGetEventApi(id: updateEventViewModel.id) { [weak self] getEventData, isSuccess in
            if isSuccess == true{
                self?.eventTitleTextField.text = getEventData?.data?.eventTitle?.capitalized
                self?.categoryTextField.text = getEventData?.data?.category?.name
                self?.organizerTextField.text = getEventData?.data?.organizer
                self?.startDateTextField.text = getEventData?.data?.startDate
                self?.endDateTextField.text = getEventData?.data?.endDate
                self?.startTimeTextField.text = getEventData?.data?.startTime
                self?.endTimeTextField.text = getEventData?.data?.endTime
                self?.venueTextField.text = getEventData?.data?.venue
                self?.addressTextField.text = getEventData?.data?.address
                self?.cityTextField.text = getEventData?.data?.city
                self?.zipCodeTextField.text = getEventData?.data?.zipcode
                self?.categoryID = getEventData?.data?.categoryID
                self?.descriptionTextView.text = getEventData?.data?.description
                self?.eventID = getEventData?.data?.id
                if let imageURL = getEventData?.data?.image{
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    self?.uploadtextField.text = urlString
                }else{
                    self?.showSimpleAlert(message: getEventData?.message ?? DefaultValue.errorMsg.rawValue)
                }}}
    }
    // MARK: Cancel Button Action--
    /// Create Function For back to Home View controller
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func cancelButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Upload Image Button Action--
    /// Create Function for select a image from gallary and Camera
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func uploadImageButtonAction(_ sender: UIButton) {
        showImagePicker()
    }
    // MARK: - Back Button Action
    /// Create Function For back to Home View controller
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Create a function for time picker--
    func timePicker(){
        let vc = UIViewController()
        vc.preferredContentSize = CGSize(width: 200,height: 200)
        let timePicker = UIDatePicker(frame: CGRect(x: -50, y: 0, width: 200, height: 200))
        let dateFormatter = DateFormatter()
        dateFormatter.dateFormat = DefaultValue.outputTimeFormat.rawValue
        timePicker.datePickerMode = .time
        vc.view.addSubview(timePicker)
        let addTimePickerAlert = UIAlertController(title: DefaultValue.selectTime.rawValue, message: AppMessage.shared.TimeStamp, preferredStyle: UIAlertController.Style.alert)
        addTimePickerAlert.setValue(vc, forKey: DefaultValue.contentController.rawValue)
        let ok = UIAlertAction(title: DefaultValue.ok.rawValue, style: .default, handler: { (action) -> Void in
            self.startTimeTextField.text = dateFormatter.string(from: timePicker.date)
        })
        let cancelAction = UIAlertAction(title: DefaultValue.cancel.rawValue, style: .default, handler: {
            (action : UIAlertAction!) -> Void in
        })
        addTimePickerAlert.addAction(ok)
        addTimePickerAlert.addAction(cancelAction)
        self.present(addTimePickerAlert, animated: true)
    }
    // MARK: - Create a function for time picker
    func getTimePicker(){
        let vc = UIViewController()
        vc.preferredContentSize = CGSize(width: 200,height: 200)
        let timePicker = UIDatePicker(frame: CGRect(x: -50, y: 0, width: 200, height: 200))
        let dateFormatter = DateFormatter()
        dateFormatter.dateFormat = DefaultValue.outputTimeFormat.rawValue
        timePicker.datePickerMode = .time
        vc.view.addSubview(timePicker)
        let addTimePickerAlert = UIAlertController(title: DefaultValue.selectTime.rawValue, message: AppMessage.shared.TimeStamp, preferredStyle: UIAlertController.Style.alert)
        addTimePickerAlert.setValue(vc, forKey: DefaultValue.contentController.rawValue)
        let ok = UIAlertAction(title: DefaultValue.ok.rawValue , style: .default, handler: { (action) -> Void in
            self.endTimeTextField.text = dateFormatter.string(from: timePicker.date)
        })
        let cancelAction = UIAlertAction(title: DefaultValue.cancel.rawValue, style: .default, handler: {
            (action : UIAlertAction!) -> Void in
        })
        addTimePickerAlert.addAction(ok)
        addTimePickerAlert.addAction(cancelAction)
        self.present(addTimePickerAlert, animated: true)
    }
    // MARK: - Create Event Api Call
    /// Create Function For Calling Create Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func updateEventButtonAction(_ sender: UIButton) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            callUpdateEventApi()
        }
    }
    // MARK: - TextFields Validation
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
        return nil}}
///Create function for set the maximum character in textfield
/// - Parameter textField: UITextField
extension UpdateEventViewController : UITextFieldDelegate{
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
    // MARK: Delegate for textfields--
    ///Create function for set the maximum character in textfield
    /// - Parameter textField: UITextField
    func textFieldShouldBeginEditing(_ textField: UITextField) -> Bool
    {
        switch textField {
        case startTimeTextField:
            self.timePicker()
            return true
        case endTimeTextField:
            self.getTimePicker()
            return true
        case categoryTextField:
            return false
        case startDateTextField:
            self.openDatePicker(textField: startDateTextField)
            return true
        case endDateTextField:
            self.openDatePicker(textField: endDateTextField)
            return true
        case uploadtextField:
            return true
        default:
            return true
        }}
}
// MARK: Extension for date picker--
extension UpdateEventViewController{
    func openDatePicker(textField: UITextField){
        let datePicker = UIDatePicker()
        datePicker.datePickerMode = .date
        if #available(iOS 14.0, *) {
            datePicker.preferredDatePickerStyle = .wheels
        } else {
        }
        textField.inputView = datePicker
        let toolbar = UIToolbar(frame: CGRect(x: 0, y: 0, width: self.view.frame.width, height: 44))
        if textField == startDateTextField{
            let cancelButton = UIBarButtonItem(title: DefaultValue.cancel.rawValue, style: .plain, target: self, action: #selector(self.cancelButtonClick))
            let doneButton = UIBarButtonItem(title: DefaultValue.done.rawValue, style: .plain, target: self, action: #selector(self.doneButtonClick))
            let flexibleButton = UIBarButtonItem(barButtonSystemItem: .flexibleSpace, target: nil, action: nil)
            toolbar.setItems([cancelButton, flexibleButton, doneButton], animated: false)
        }else{
            let cancelButton = UIBarButtonItem(title: DefaultValue.cancel.rawValue, style: .plain, target: self, action: #selector(self.cancelButtonClick2))
            let doneButton = UIBarButtonItem(title: DefaultValue.done.rawValue, style: .plain, target: self, action: #selector(self.doneButtonClick2))
            let flexibleButton = UIBarButtonItem(barButtonSystemItem: .flexibleSpace, target: nil, action: nil)
            toolbar.setItems([cancelButton, flexibleButton, doneButton], animated: false)
        }
        textField.inputAccessoryView = toolbar
    }
    // MARK: create a function for hide calender on cancel Click--
    @objc func cancelButtonClick(){
        startDateTextField.resignFirstResponder()
    }
    // MARK: Create a function for getting the date on done Button click--
    @objc func doneButtonClick(){
        if let datePicker = startDateTextField.inputView as? UIDatePicker{
            let dateFormatter = DateFormatter()
            dateFormatter.dateStyle = .medium
            dateFormatter.dateFormat = DefaultValue.inputDateFormat.rawValue
            startDateTextField.text = dateFormatter.string(from: datePicker.date)
            debugPrint(datePicker)}
        startDateTextField.resignFirstResponder()
    }
    // MARK: create a function for hide calender on cancel Click--
    @objc func cancelButtonClick2(){
        endDateTextField.resignFirstResponder()
    }
    // MARK: Create a function for getting the date on done Button click--
    @objc func doneButtonClick2(){
        if let datePicker = endDateTextField.inputView as? UIDatePicker{
            let dateFormatter = DateFormatter()
            dateFormatter.dateStyle = .medium
            dateFormatter.dateFormat = DefaultValue.inputDateFormat.rawValue
            endDateTextField.text = dateFormatter.string(from: datePicker.date)
            debugPrint(datePicker)}
        endDateTextField.resignFirstResponder()
    }
}
// MARK: create extension for textview--
extension UpdateEventViewController: UITextViewDelegate{
    func textViewDidBeginEditing(_ textView: UITextView) {
        if textView.textColor == UIColor.lightGray {
            textView.text = nil
            textView.textColor = UIColor.white
        }}}
extension UpdateEventViewController{
    public func imagePickerController(_ picker: UIImagePickerController,
                                      didFinishPickingMediaWithInfo info: [UIImagePickerController.InfoKey: Any]) {
        guard let image = info[.originalImage] as? UIImage else {
            return
        }
        let imageIs = UUID().uuidString
        let imagePath = getDocumentsDirectory().appendingPathComponent(imageIs)
        if let jpegData = image.jpegData(compressionQuality: 0.8) {
            try? jpegData.write(to: imagePath)
        }
        self.uploadtextField.text = "\(imagePath)"
        updateEventViewModel.media.removeAll()
        updateEventViewModel.media.append(Media(withImage: image, forKey:DefaultValue.image.rawValue)!)
        self.dismiss(animated: true, completion: nil)
    }
    func getDocumentsDirectory() -> URL {
        let paths = FileManager.default.urls(for: .documentDirectory, in: .userDomainMask)
        return paths[0]
    }
}
