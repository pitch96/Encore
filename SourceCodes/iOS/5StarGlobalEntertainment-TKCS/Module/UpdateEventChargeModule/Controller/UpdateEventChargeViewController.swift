//
//  UpdateEventChargeViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 28/04/23.
//

import UIKit

class UpdateEventChargeViewController: UIViewController {
    // MARK: - IBOutlets
    @IBOutlet weak var priceTextField: UITextField!
    // MARK: - Variable initializer
    var updateEventChargeModel = UpdateEventChargeModel()
    lazy var updateEventChargeViewModel:UpdateEventChargeViewModel = {
        var updateEventChargeViewModel = UpdateEventChargeViewModel()
        return updateEventChargeViewModel
    }()
    var chargeID : Int?
    
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        getCharge()
        priceTextField.delegate = self
        // Do any additional setup after loading the view.
    }
    // MARK: - Create function for call get charge API
    func getCharge(){
        updateEventChargeViewModel.callEventChargeApi {[weak self] chargeAmmout, isSuccess in
            if isSuccess == true{
                self?.chargeID = chargeAmmout.data?.id
                self?.priceTextField.text = "\(chargeAmmout.data?.charge ?? 0)"
            }else{
                self?.showSimpleAlert(message: chargeAmmout.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - create function for call update charge API
    func updateCharge(){
        updateEventChargeViewModel.callUpdateEventChargeApi(id: chargeID, charge: priceTextField.text) {[weak self] updatePrice, isSuccess in
            if isSuccess == true{
                self?.priceTextField.text = updatePrice?.data?.charge
                self?.refreshAlert(title: Alert.projectName, message: updatePrice?.message ?? DefaultValue.errorMsg.rawValue)
            }else{
                self?.showSimpleAlert(message: updatePrice?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
        
    }
    // MARK: - Back Button Action
    /// Navigate to previous Screen
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: - Cancel Button Action
    /// Navigate to previous Screen
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func CancelButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: - Update Price Button Action
    /// create action for calling update Price Api
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func updatePriceAction(_ sender: Any) {
        let alertmessage = validation()
        if let alertmessage = alertmessage{
            self.showSimpleAlert(message: alertmessage)
        }else{
            updateCharge()
        }
        
    }
    // MARK: - Validation for textfields
    func validation()->String?{
        guard !(String.getString(self.priceTextField.text).isEmpty) else{return AppMessage.shared.EnterAmount}
        guard !(String.getString(self.priceTextField.text) == "0") else {return AppMessage.shared.ValidAmount}
        return nil
        
    }
    
}
// MARK: - Create extension for Textfield delegate
extension UpdateEventChargeViewController: UITextFieldDelegate{
        ///Create function for set the maximum character in textfield
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
                return count <= 10
            default:
                return true
            }
        }
    }
