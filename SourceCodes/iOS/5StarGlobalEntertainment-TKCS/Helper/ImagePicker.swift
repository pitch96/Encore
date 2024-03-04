//
//  ImagePicker.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 04/01/23.
//

import Foundation

import UIKit
import PhotosUI
// MARK: - Protocol for image picker
public protocol ImagePickerDelegate: AnyObject {
    func didSelectImage(image: UIImage?,imageName:String
    )
}
// MARK: - Class for image Picker
open class ImagePicker: NSObject {
    // MARK: - Variable initializer
    private let pickerController: UIImagePickerController
    private weak var presentationController: UIViewController?
    private weak var delegate: ImagePickerDelegate?
    private var imageName: String?
    
    public init(presentationController: UIViewController, delegate: ImagePickerDelegate) {
        self.pickerController = UIImagePickerController()
        super.init()
        self.presentationController = presentationController
        self.delegate = delegate
        self.pickerController.delegate = self
        self.pickerController.allowsEditing = true
        self.pickerController.mediaTypes = ["public.image"]
    }
    // MARK: - Create function for action in image picker
    private func action(for type: UIImagePickerController.SourceType, title: String) -> UIAlertAction? {
        guard UIImagePickerController.isSourceTypeAvailable(type) else {
            return nil
        }
        return UIAlertAction(title: title, style: .default) { [unowned self] _ in
            self.pickerController.sourceType = type
            self.presentationController?.present(self.pickerController, animated: true)
        }
    }
    // MARK: - Create functyion for present View for Choose library or camera
    public func present(from sourceView: UIView) {
        
        let alertController = UIAlertController(title: AppMessage.shared.PickPhoto, message: AppMessage.shared.ChooseLibrary, preferredStyle: .actionSheet)
        if let action = self.action(for: .camera, title: "Camera") {
            alertController.addAction(action)
        }
        if let action = self.action(for: .photoLibrary, title: "Photo library") {
            alertController.addAction(action)
        }
        alertController.addAction(UIAlertAction(title: "Cancel", style: .cancel, handler: nil))
        if UIDevice.current.userInterfaceIdiom == .pad {
            alertController.popoverPresentationController?.sourceView = sourceView
            alertController.popoverPresentationController?.sourceRect = sourceView.bounds
            alertController.popoverPresentationController?.permittedArrowDirections = [.down, .up]
        }
        self.presentationController?.present(alertController, animated: true)
    }
    // MARK: - Create function for choose image from library or camera
    private func pickerController(_ controller: UIImagePickerController, didSelect image: UIImage?) {
        controller.dismiss(animated: true, completion: nil)
        self.delegate?.didSelectImage(image: image, imageName: imageName ?? DefaultValue.emptyString.rawValue)
    }
}
// MARK: - Create extension for image picker delegate
extension ImagePicker: UIImagePickerControllerDelegate {
    public func imagePickerControllerDidCancel(_ picker: UIImagePickerController) {
        self.pickerController(picker, didSelect: nil)
    }
    public func imagePickerController(_ picker: UIImagePickerController,
                                      didFinishPickingMediaWithInfo info: [UIImagePickerController.InfoKey: Any]) {
        
        guard let image = info[.originalImage] as? UIImage else {
            return self.pickerController(picker, didSelect: nil)
        }
        let imageIs = UUID().uuidString
        let imagePath = getDocumentsDirectory().appendingPathComponent(imageIs)
        if let jpegData = image.jpegData(compressionQuality: 0.8) {
              try? jpegData.write(to: imagePath)
          }
        imageName = imageIs
        self.pickerController(picker, didSelect: image)
    }
    // MARK: - Create function for fetch the path of image
    func getDocumentsDirectory() -> URL {
        let paths = FileManager.default.urls(for: .documentDirectory, in: .userDomainMask)
        return paths[0]
    }
}
extension ImagePicker: UINavigationControllerDelegate {

}
