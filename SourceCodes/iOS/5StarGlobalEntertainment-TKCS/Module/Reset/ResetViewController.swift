//
//  ResetViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 01/12/22.
//

import UIKit

class ResetViewController: UIViewController {

    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    @IBAction func continueLoginButton(_ sender: Any) {
        self.navigationController?.popToRootViewController(animated: true)
    }
    
}
