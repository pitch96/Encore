//
//  EditBannerViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/03/23.
//

import UIKit

class EditBannerViewController: UIViewController, UIImagePickerControllerDelegate & UINavigationControllerDelegate {
// MARK: IBOutlets--
    @IBOutlet weak var uploadTextfield: UITextField!
    @IBOutlet weak var descriptionTextView: UITextView!
    // MARK: Variable initializer--
    var imagePicker = UIImagePickerController()
    var updateBannerModel : UpdateBannerModel?
    lazy var updateBannerViewModel:UpdateBannerViewModel = {
        var updateBannerViewModel = UpdateBannerViewModel()
        return updateBannerViewModel
    }()
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        imagePicker.delegate = self
        // Do any additional setup after loading the view.
        uploadTextfield.isUserInteractionEnabled = false
        getBannerDetailApi()
    }
    func getBannerDetailApi(){
        updateBannerViewModel.callBannerApi(id: updateBannerViewModel.id) {[weak self] bannerDetail, isSuccess in
            if isSuccess == true{
                self?.descriptionTextView.attributedText = bannerDetail?.data?.description?.convertHtmlToAttributedStringWithCSS(font: UIFont(name: DefaultValue.Arial.rawValue, size: 22), csscolor: DefaultValue.white.rawValue, lineheight: 5, csstextalign: DefaultValue.left.rawValue )
                if let imageURL = bannerDetail?.data?.bannerImage{
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    self?.uploadTextfield.text = urlString
                }else{
                    self?.showSimpleAlert(message: bannerDetail?.message ?? DefaultValue.errorMsg.rawValue)
                }
            }}
    }
    
    // MARK: Back Button Action--
    ///Create action for navigate to previous screen
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: uplaod image Button Action--
    ///Create action for upload image and show option for uplaod image
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func browseButtonAction(_ sender: UIButton) {
        showImagePicker()
    }
    // MARK: Cancel Button Action--
    ///Create action for back to previous screen
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func cancelButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: update Banner Button Action--
    ///Create action for update Api call
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func updateBannerAction(_ sender: UIButton) {
        UpdateBannerApi()
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
    
    // MARK: Create function for update banner API--
    func UpdateBannerApi(){
        updateBannerViewModel.callUpdateBannerApi(description: descriptionTextView.text ??  DefaultValue.emptyString.rawValue, image: self.updateBannerViewModel.media.first?.filename ?? DefaultValue.emptyString.rawValue, file: self.updateBannerViewModel.media) {[weak self] updateBannerData, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: updateBannerData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.updateBannerViewModel.media.removeAll()
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                self?.showSimpleAlert(message: updateBannerData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
}
///Create function for set the textView placeholder in TextView
/// - Parameter textField: UITextField
extension EditBannerViewController: UITextViewDelegate{
    func textViewDidBeginEditing(_ textView: UITextView) {
        if descriptionTextView.textColor == UIColor.lightGray {
            descriptionTextView.text = nil
            descriptionTextView.textColor = UIColor.white
        }
    }
}
extension EditBannerViewController{
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
        self.uploadTextfield.text = "\(imagePath)"
        updateBannerViewModel.media.removeAll()
        updateBannerViewModel.media.append(Media(withImage: image, forKey: DefaultValue.BannerImage.rawValue)!)
        self.dismiss(animated: true, completion: nil)
    }
    func getDocumentsDirectory() -> URL {
        let paths = FileManager.default.urls(for: .documentDirectory, in: .userDomainMask)
        return paths[0]
    }
}
