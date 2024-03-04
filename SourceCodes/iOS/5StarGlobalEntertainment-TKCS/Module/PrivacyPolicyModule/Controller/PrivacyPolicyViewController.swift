//
//  PrivacyPolicyViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import UIKit

class PrivacyPolicyViewController: UIViewController {
    // MARK: IBOutlets--
    @IBOutlet weak var lblPrivacy: UILabel!
    // MARK: Variable Initializer--
    var privacyPolicyModel : PrivacyPolicyModel?
    lazy var privacyPolicyViewModel:PrivacyPolicyViewModel = {
        var privacyPolicyViewModel = PrivacyPolicyViewModel()
        return privacyPolicyViewModel
    }()
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        PrivacyPolicyCall()
    }
    // MARK: Create a function for calling privacy policy Api--
    func PrivacyPolicyCall(){
        privacyPolicyViewModel.callPrivacyPolicyApi { [weak self] privacyData, isSuccess in
            if isSuccess == true{
                let text = NSAttributedString(string: privacyData.data ?? DefaultValue.errorMsg.rawValue).withLineSpacing(10)
                self?.lblPrivacy.attributedText = text
            }else{
                self?.showSimpleAlert(message: privacyData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: Function for navigate to previous Screen--
    /// Create Function For back to
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
}
