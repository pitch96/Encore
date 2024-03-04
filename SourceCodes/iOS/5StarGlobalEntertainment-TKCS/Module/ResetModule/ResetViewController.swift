//
//  ResetViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 01/12/22.
//

import UIKit

class ResetViewController: UIViewController {
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
    }
    // MARK: create function for change status bar color--
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    // MARK: Continue Button Action--
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func continueLoginButton(_ sender: Any) {
        self.navigationController?.popToRootViewController(animated: true)
    }
    
}
