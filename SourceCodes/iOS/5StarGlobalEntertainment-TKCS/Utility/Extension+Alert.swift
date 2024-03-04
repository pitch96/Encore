//
//  Extension+Alert.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import Foundation
import UIKit
extension UIViewController {
    func showSimpleAlert(message:String) {
let alert = UIAlertController(title: "Alert",message: message ,preferredStyle: UIAlertController.Style.alert)
alert.addAction(UIAlertAction(title: "OK", style: UIAlertAction.Style.default, handler: { _ in
}))
        self.present(alert, animated: true, completion: nil)
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

//struct Alert{
//    static func showMessage(title: String = Constant.Defualt.emptyString, message: String = Constant.Defualt.emptyString) {
//        let objAlert: UIAlertController = UIAlertController(title: title, message: message, preferredStyle: .alert)
//        //Create and an option action
//
//        let nextAction: UIAlertAction = UIAlertAction(title: Constant.Localizable.kOkTitle, style: .cancel)
//
//        objAlert.addAction(nextAction)
//
//        var rootViewController = UIApplication.shared.keyWindow?.rootViewController
//
//        if let presented = rootViewController?.presentedViewController{
//          rootViewController = presented
//        }else if let navigationController = rootViewController as? UINavigationController {
//            rootViewController = navigationController.viewControllers.last
//        }
//        rootViewController?.present(objAlert, animated: true, completion: nil)
//
//        let when = DispatchTime.now() + 3
//        DispatchQueue.main.asyncAfter(deadline: when){
//            objAlert.dismiss(animated: true, completion: nil)
//        }
//
//    }
//
//
//    ///  Alert to enable location.
//    ///
//    /// - Parameters:nil
//    static func enableLocationSettings() {
//
//        let alertController = UIAlertController(title: Constant.Localizable.kEnableLocation,
//                                                message: Constant.Localizable.kLocationMessage,
//                                                preferredStyle: .alert)
//
//        let settingsAction = UIAlertAction(title: Constant.Localizable.kSetting, style: .default) { (alertAction) in
//
//
//            if let bundleId = Bundle.main.bundleIdentifier,
//                let url = URL(string: "\(UIApplication.openSettingsURLString)&path=LOCATION/\(bundleId)") {
//                UIApplication.shared.open(url, options: [:], completionHandler: nil)
//            }
//
//        }
//        alertController.addAction(settingsAction)
//
//        let cancelAction = UIAlertAction(title: Constant.Localizable.kCancelTitle, style: .cancel, handler: nil)
//        alertController.addAction(cancelAction)
//        let when = DispatchTime.now()
//
//        DispatchQueue.main.asyncAfter(deadline: when){
//          UIApplication.shared.keyWindow?.rootViewController?.present(alertController, animated: true, completion: nil)
//        }
//
//    }
//
//    /// Display Alert with Ok and cancel
//    ///
//    /// - Parameters:
//    ///   - title: String?
//    ///   - message: String
//    ///   - view: UIViewController
//    ///   - completion: @escaping () -> Void
//    ///   - cancel: @escaping () -> Void
//    static func showAlertMessageWithOkAndCancelAction(title: String? = nil, message: String, completion: @escaping () -> Void, cancel: @escaping () -> Void) {
//        let objAlert: UIAlertController = UIAlertController(title: title, message: message, preferredStyle: .alert)
//        //Create and an option action
//        let nextAction: UIAlertAction = UIAlertAction(title: Constant.Localizable.kOkTitle, style: .default) { action -> Void in
//            completion()
//        }
//        let cancelAction: UIAlertAction = UIAlertAction(title: Constant.Localizable.kCancelTitle, style: .cancel) { action -> Void in
//            cancel()
//        }
//        objAlert.addAction(nextAction)
//        objAlert.addAction(cancelAction)
//
//        var rootViewController = UIApplication.shared.keyWindow?.rootViewController
//        if let presented = rootViewController?.presentedViewController{
//          rootViewController = presented
//        }else if let navigationController = rootViewController as? UINavigationController {
//            rootViewController = navigationController.viewControllers.first
//        }
//        rootViewController?.present(objAlert, animated: true, completion: nil)
//
//       }
//}
