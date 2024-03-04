//
//  ProfileViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/12/22.
//

import UIKit
import SDWebImage
import IQKeyboardManagerSwift

class ProfileViewController: UIViewController {
    //Interface
    // MARK: - IBoulets
    @IBOutlet weak var viewProfileImage: UIView!
    @IBOutlet weak var imageProfile: UIImageView!
    @IBOutlet weak var txtUsername: UITextField!
    @IBOutlet weak var txtFullName: UITextField!
    @IBOutlet weak var txtEmailId: UITextField!
    @IBOutlet weak var txtCompanyName: UITextField!
    @IBOutlet weak var txtContactNumber: UITextField!
    @IBOutlet weak var viewEdit: GradientBackgroundView!
    @IBOutlet weak var btnEdit: UIButton!
    // MARK: - Variable Initializer
    var profileViewModel = ProfileViewModel()
    private var image = UIImage()
    
    // MARK: - View Life Cycle
    override func viewDidLoad() {
        super.viewDidLoad()
        //self.profileDetail()
        txtUsername.delegate = self
        txtFullName.delegate = self
        txtCompanyName.delegate = self
        self.txtContactNumber.delegate = self
        viewProfileImage.layer.borderWidth = 5.0
        viewProfileImage.layer.masksToBounds = false
        viewProfileImage.layer.borderColor = UIColor.white.cgColor
        viewProfileImage.layer.cornerRadius = viewProfileImage.frame.size.width / 2
        viewProfileImage.clipsToBounds = true
        viewEdit.layer.cornerRadius = viewEdit.frame.size.width / 2
        
    }
    // MARK: - view Will Appear
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        profileDetail()
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: - Create function for calling payout API Call
  
    
    // MARK: Profile button Action
    ///Create a function for pick image in edit button click
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func btnEditProfile(_ sender: UIButton) {
        showImagePicker()
    }
    
    // MARK: - Update Profile APi Call
    /// Create Function For Calling Update Profile Api
    /// return : UIButton
    @IBAction func btnUpdateProfile(_ sender: UIButton) {
        DispatchQueue.main.async {
            self.profileViewModel.CallProfileUpdateApi(fName: self.txtUsername.text ?? DefaultValue.emptyString.rawValue, lName: self.txtFullName.text ?? DefaultValue.emptyString.rawValue, phoneNum: self.txtContactNumber.text ?? DefaultValue.emptyString.rawValue, companyName: self.txtCompanyName.text ?? DefaultValue.emptyString.rawValue, userProfile: self.profileViewModel.media.first?.filename ?? DefaultValue.emptyString.rawValue, file: self.profileViewModel.media) { editData, isSuccess in
                if editData.success == true{
                    self.showSimpleAlert(message: editData.message ?? DefaultValue.errorMsg.rawValue)
                    self.profileViewModel.media.removeAll()
                }else{
                    self.showSimpleAlert(message: editData.message ?? DefaultValue.errorMsg.rawValue)
                }
            }
        }
    }
    
    // MARK: - Get Profile APi Call
    /// Create Function For Calling Get Profile Api
    /// return : nil
    func profileDetail(){
        profileViewModel.CallProfileApi(completition: { profileData, isSuccess in
            if isSuccess == true {
                self.txtUsername.text = profileData.data?.firstName
                self.txtFullName.text = profileData.data?.lastName ?? DefaultValue.emptyString.rawValue
                self.txtEmailId.text = profileData.data?.email
                self.txtEmailId.isUserInteractionEnabled = false
                self.txtContactNumber.text = profileData.data?.phoneNo
                self.txtCompanyName.text = profileData.data?.companyName
                if let imageURL = profileData.data?.userImage{
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    self.imageProfile.sd_setImage(with: URL(string: urlString),placeholderImage: UIImage(systemName: DefaultValue.imagePerson.rawValue))
                }
            }else{
                //self.showSimpleAlert(message: profileData.message ?? DefaultValue.emptyString.rawValue)
            }
        })
    }
    // MARK: - TextFields Validation
    /// Create Function For TextField Validation
    /// - Returns: String(Optional)
    func validation() -> String?{
        guard !(String.getString(self.txtUsername.text).isEmpty) else{return AppMessage.shared.Username}
        guard String.getString(self.txtUsername.text).isUsername() else{return AppMessage.shared.EnterValidUsrename}
        guard !(String.getString(self.txtFullName.text).isEmpty) else{return AppMessage.shared.Fullname}
        guard String.getString(self.txtFullName.text).isFullName() else{return AppMessage.shared.ValidFullname}
        guard !(String.getString(self.txtEmailId.text).isEmpty) else{return AppMessage.shared.pleaseEnterEmailAddress}
        guard String.getString(self.txtEmailId.text).isEmail() else{return AppMessage.shared.pleaseEnterValidEmailAddress}
        guard !(String.getString(self.txtCompanyName.text).isEmpty) else{return AppMessage.shared.PleaseEnterPassword}
        guard String.getString(self.txtCompanyName.text).isName() else{return AppMessage.shared.PleaseEnterValidPassword}
        guard !(String.getString(self.txtContactNumber.text).isEmpty) else{return AppMessage.shared.contactNumber}
        guard (String.getString(self.txtContactNumber.text)).isPhoneNumber() else{return AppMessage.shared.EnterValidContact}
        return nil
    }
    
}
// MARK: - Extension for image pikcer Delegate
extension ProfileViewController: UIImagePickerControllerDelegate, UINavigationControllerDelegate, UIPopoverPresentationControllerDelegate{
    func showImagePicker(){
        let alert = UIAlertController(title: AppMessage.shared.PickPhoto, message: AppMessage.shared.ChooseLibrary, preferredStyle: .actionSheet)
        alert.addAction(UIAlertAction(title: AppMessage.shared.Camera, style: .default, handler: { _ in
            self.openCamera()
        }))
        
        alert.addAction(UIAlertAction(title: AppMessage.shared.Gallary, style: .default, handler: { _ in
            self.openGallery()
        }))
        
        alert.addAction(UIAlertAction.init(title: AppMessage.shared.Cancel, style: .cancel, handler: nil))
        if let popoverController = alert.popoverPresentationController {
            popoverController.sourceView = self.view //to set the source of your alert
            popoverController.sourceRect = CGRect(x: self.view.bounds.midX, y: self.view.bounds.midY, width: 0, height: 0) // you can set this as per your requirement.
            popoverController.permittedArrowDirections = [] //to hide the arrow of any particular direction
        }
        //        self.modalPresentationStyle = .overCurrentContext
        self.present(alert, animated: true, completion: nil)
    }
    
    // MARK: - Pick Image from Camera
    func openCamera()
    {
        if UIImagePickerController.isSourceTypeAvailable(UIImagePickerController.SourceType.camera) {
            let imagePicker = UIImagePickerController()
            imagePicker.delegate = self
            imagePicker.sourceType = UIImagePickerController.SourceType.camera
            imagePicker.allowsEditing = false
            self.present(imagePicker, animated: true, completion: nil)
        }
    }
    // MARK: - Pick Image from Gallery
    ///create a function for open gallary
    func openGallery()
    {
        if UIImagePickerController.isSourceTypeAvailable(UIImagePickerController.SourceType.photoLibrary){
            let imagePicker = UIImagePickerController()
            imagePicker.delegate = self
            imagePicker.allowsEditing = true
            imagePicker.sourceType = UIImagePickerController.SourceType.photoLibrary
            self.present(imagePicker, animated: true, completion: nil)
        }
        
    }
    
    // MARK: - Create a fuction to set picked a image from libary and camera
    func imagePickerController(_ picker: UIImagePickerController, didFinishPickingMediaWithInfo info: [UIImagePickerController.InfoKey : Any]) {
        if let pickedImage = info[.originalImage] as? UIImage {
            imageProfile.image = pickedImage
            self.image = pickedImage
            guard let media = Media(withImage: pickedImage, forKey: ProfileApiParam.user_profile) else {return}
            self.profileViewModel.media.append(media)
        }
        picker.dismiss(animated: true, completion: nil)
    }
}

// MARK: - Set the Number Format in PhoneTextField
/// - Parameters: (mask, phone)
///   - mask: String
///   - phone: String
/// - Returns: String
extension ProfileViewController{
    func format(with mask: String, phone: String) -> String {
        let numbers = phone.replacingOccurrences(of: DefaultValue.ranges.rawValue, with: DefaultValue.emptyString.rawValue, options: .regularExpression)
        var result = DefaultValue.emptyString.rawValue
        var index = numbers.startIndex
        for ch in mask where index < numbers.endIndex {
            if ch == "X" {
                result.append(numbers[index])
                index = numbers.index(after: index)
            } else {
                result.append(ch)
            }
        }
        return result
    }
}
// MARK: - TextField Delegate
///Create function for set the number format  in textfield
/// - Parameter textField: UITextField
extension ProfileViewController: UITextFieldDelegate{
    
    // MARK: Create a function for phone format in textfield
    func textFieldDidChangeSelection(_ textField: UITextField) {
        txtContactNumber.text = self.format(with: DefaultValue.numberFormat.rawValue, phone: txtContactNumber.text ?? DefaultValue.emptyString.rawValue)
        
    }
    // MARK: - TextField Delegate
    ///Create function for set the maximum character limit  in textfield
    /// - Parameter textField: UITextField
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case txtUsername:
            guard let textFieldText = txtUsername.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 25
        case txtFullName:
            guard let textFieldText = txtFullName.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 25
        case txtCompanyName:
            guard let textFieldText = txtCompanyName.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 80
        default:
            return true
        }
    }
}
