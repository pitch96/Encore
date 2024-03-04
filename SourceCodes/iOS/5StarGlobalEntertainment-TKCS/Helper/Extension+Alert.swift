//
//  Extension+Alert.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import Foundation
import UIKit


extension UIViewController {
    
    func showSimpleAlert(message:String,  boolean: Bool = false) {
        let alert = UIAlertController(title: Alert.projectName,message: message ,preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: UIAlertAction.Style.default, handler: { _ in
        }))
        self.present(alert, animated: true, completion: nil)
    }
    func refreshAlert(title: String, message: String) {
        let alert = UIAlertController(title: title, message: message, preferredStyle: .alert)
        alert.addAction(UIAlertAction(title: Alert.okTitle, style: .default, handler: {(action) in
            //alert.dismiss(animated: true, completion: nil)
            self.navigationController?.popViewController(animated: true)
        }))
        
        self.present(alert,animated: true, completion: nil)
    }
   
    // MARK: OPEN TOAST MESSAGE
    func showToast(message : String) {
        
        let toastLabel = UILabel(frame: CGRect(x: 30 , y: self.view.frame.size.height-140, width: self.view.frame.size.width - 60, height: 45))
        //        toastLabel.backgroundColor = .white
        toastLabel.numberOfLines = 0
        toastLabel.textColor = UIColor.white
        toastLabel.font = UIFont.systemFont(ofSize: 16, weight: .semibold)
        toastLabel.textAlignment = .center
        toastLabel.text = message
        toastLabel.alpha = 1.0
        toastLabel.layer.cornerRadius = 10
        toastLabel.layer.borderWidth = 0.5
        toastLabel.layer.borderColor = UIColor.lightGray.cgColor

        self.view.addSubview(toastLabel)
        UIView.animate(withDuration: 4.0, delay: 0.0, options: .layoutSubviews, animations: {
            toastLabel.alpha = 0.9
        }, completion: {(isCompleted) in
            toastLabel.removeFromSuperview()
        })
    }
    static func getStoryboardID()->String
    {
        return String.init(describing: self)
    }
    static func storyboardID()->String
    {
        return String.init(describing: self)
        
    }
    
}
