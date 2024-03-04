//
//  TermsConditionViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import UIKit

class TermsConditionViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var lblTermsCondition: UILabel!
    
    // MARK: Variable Initializer--
    var termsConditionModel : TermsConditionModel?
    lazy var termsConditionViewModel:TermsConditionViewModel = {
        var termsConditionViewModel = TermsConditionViewModel()
        return termsConditionViewModel
    }()
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        termsAndConditionApi()
    }
    // MARK: Create a function for calling terms condtion Api--
    func termsAndConditionApi(){
        termsConditionViewModel.callTermsContionApi { [weak self] termsConditionData, isSuccess in
            if isSuccess == true{
                let text = NSAttributedString(string: termsConditionData.data ?? DefaultValue.emptyString.rawValue).withLineSpacing(10)
                self?.lblTermsCondition.attributedText = text
            }else{
                self?.showSimpleAlert(message: termsConditionData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Function for navigate to previous Screen--
    /// Create Function For back to
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
