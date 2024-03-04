//
//  AddCategoryViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/02/23.
//

import UIKit

class AddCategoryViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var categoryTextField: UITextField!
    
    // MARK: Variable Initializer--
    var addCategoryModel : AddCategoryModel?
    lazy var addCategoryViewModel:AddCategoryViewModel = {
        var addCategoryViewModel = AddCategoryViewModel()
        return addCategoryViewModel
    }()
      // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        categoryTextField.delegate = self
        // Do any additional setup after loading the view.
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Navigate To Home View Controller--
    /// Create Function For Navigate to Home View Controller
    /// - Parameter sender : UIButton
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
   // MARK: Create action for pop to view Controller--
    @IBAction func cancelButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: add category Api calling--
    /// Create Function For calling add category
    /// - Parameter sender : UIButton
    @IBAction func addCategoryButtonAction(_ sender: Any) {
        addCategoryViewModel.callAddCategoryApi(fName: self.categoryTextField.text ?? DefaultValue.emptyString.rawValue) {[weak self] addCategoryData, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: addCategoryData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    let vc = self?.storyboard?.instantiateViewController(withIdentifier:ManageCategoryViewController.identifier) as! ManageCategoryViewController
                    self?.navigationController?.pushViewController(vc, animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                self?.showSimpleAlert(message: addCategoryData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
}
// MARK: Create extension for textfield delegate--
extension AddCategoryViewController: UITextFieldDelegate{
    ///Create function for set the maximum character in textfield
    /// - Parameter textField: UITextField
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        switch textField {
        case categoryTextField:
            guard let textFieldText = categoryTextField.text,
                  let rangeOfTextToReplace = Range(range, in: textFieldText) else {
                return false
            }
            let substringToReplace = textFieldText[rangeOfTextToReplace]
            let count = textFieldText.count - substringToReplace.count + string.count
            return count <= 25
        default:
            return true
        }
    }
}
