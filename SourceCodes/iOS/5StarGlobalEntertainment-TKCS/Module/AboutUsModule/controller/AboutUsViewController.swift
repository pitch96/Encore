//
//  AboutUsViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 24/01/23.
//

import UIKit

class AboutUsViewController: UIViewController{
    // MARK: IBOutlets--
    @IBOutlet weak var lblAboutUs: UILabel!
    
    // MARK: Variable initializer--
    var aboutUsModel : AboutUsModel?
    lazy var aboutUsViewModel:AboutUsViewModel = {
        var aboutUsViewModel = AboutUsViewModel()
        return aboutUsViewModel
    }()
    
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        aboutusApi()
        
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Create a function for calling About us API--
    func aboutusApi(){
        aboutUsViewModel.callAboutUsApi {[weak self] aboutusData, isSuccess in
            if isSuccess == true{
                let text = NSAttributedString(string: aboutusData.data ?? DefaultValue.errorMsg.rawValue).withLineSpacing(10)
                self?.lblAboutUs.attributedText = text
            }else{
                self?.showSimpleAlert(message: aboutusData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Back button Action
    //Create function for back to home view Controller
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
