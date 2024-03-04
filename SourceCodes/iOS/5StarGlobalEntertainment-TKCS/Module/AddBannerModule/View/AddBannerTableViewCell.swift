//
//  AddBannerTableViewCell.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/03/23.
//

import UIKit

class AddBannerTableViewCell: UITableViewCell {
    // MARK: IBOtlets--
    @IBOutlet weak var browseButton: UIButton!
    @IBOutlet weak var descriptionTextView: UITextView!
    @IBOutlet weak var addCellButton: UIButton!
    @IBOutlet weak var imageTextfield: UITextField!
    
    // MARK: Variable Initializer--
    var indexPath = 0
    var addBannerVC :AddBannerViewController?
    var imagePicker: ImagePicker!
    var backCall: ((_ : Int) -> Void)?
    var getText: ((_ : String) -> Void)?

    // MARK: viewDidLoad--
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
        imageTextfield.isUserInteractionEnabled = false
        descriptionTextView.delegate = self
        descriptionTextView.text = DefaultValue.query.rawValue
        descriptionTextView.textColor = UIColor.lightGray
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }
    // MARK: Upload Button Action--
    /// Create Function For back call to controller to get the image path
    /// - Parameter sender: UIButton
    /// return :nil
    @IBAction func uploadPhotoAction(_ sender: UIButton) {
        self.backCall?(sender.tag)
    }
    
}
// MARK: create Extension for TextView Delegate--
///Create function for set the textView placeholder in TextView
/// - Parameter textField: UITextField
extension AddBannerTableViewCell: UITextViewDelegate{
    func textViewDidBeginEditing(_ textView: UITextView) {
        if textView.textColor == UIColor.lightGray {
            textView.text = nil
            textView.textColor = UIColor.white
        }
    }
    
    func textViewDidChange(_ textView: UITextView){
        
        self.getText?(textView.text)
        
    }
}
