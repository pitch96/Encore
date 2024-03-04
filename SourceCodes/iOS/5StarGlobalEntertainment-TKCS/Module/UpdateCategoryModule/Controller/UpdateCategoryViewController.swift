//
//  UpdateCategoryViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 06/02/23.
//

import UIKit

class UpdateCategoryViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var nameTextField: UITextField!
    // MARK: Variable Initializer--
    var updateCategoryModel : UpdateCategoryModel?
    lazy var updateCategoryViewModel:UpdateCategoryViewModel = {
        var updateCategoryViewModel = UpdateCategoryViewModel()
        return updateCategoryViewModel
    }()
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        getCategoryDetailAPi()
        nameTextField.delegate = self
        // Do any additional setup after loading the view.
    }
    // MARK: getCategory APi call--
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
       // getCategoryDetailAPi()
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Create a function for Calling GetCategory Api--
    func getCategoryDetailAPi(){
        updateCategoryViewModel.callGetCategoryApi(id: updateCategoryViewModel.id) {[weak self] getCategoryData, isSuccess in
            if isSuccess == true{
                self?.nameTextField.text = getCategoryData?.data?.name
            }else{
                self?.showSimpleAlert(message: getCategoryData?.message ?? DefaultValue.errorMsg.rawValue)
            }}}
    // MARK: Button action for navigation--
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Button action Update Category APi Call--
    /// Create Function For Update Category
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func updateCategoryButtonAction(_ sender: UIButton) {
        callUpdateUserApi()
    }
    // MARK: create function for calling update user APi--
    func callUpdateUserApi(){
        updateCategoryViewModel.callUpdateCategoryApi(id: updateCategoryViewModel.id, fName: nameTextField.text ?? DefaultValue.emptyString.rawValue) {[weak self] updateCategoryData, isSuccess in
            if isSuccess == true{
                let refreshAlert = UIAlertController(title: Alert.projectName, message: updateCategoryData?.message ?? DefaultValue.emptyString.rawValue, preferredStyle: UIAlertController.Style.alert)
                refreshAlert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: { (action: UIAlertAction!) in
                    self?.navigationController?.popViewController(animated: true)
                }))
                self?.present(refreshAlert, animated: true, completion: nil)
            }else{
                self?.showSimpleAlert(message: updateCategoryData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Cancel Button Action--
    /// Navigate to previous Screen
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func cancelButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
}
// MARK: Create extention for textfield delegate--
extension UpdateCategoryViewController: UITextFieldDelegate{
        ///Create function for set the maximum character in textfield
        /// - Parameter textField: UITextField
        func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
            switch textField {
            case nameTextField:
                guard let textFieldText = nameTextField.text,
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
