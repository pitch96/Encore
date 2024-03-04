//
//  Common.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/12/22.
//

import Foundation
import UIKit
import SideMenu

public class Common: NSObject {
    static let shared = Common()
    var menu: SideMenuNavigationController?
    // MARK: - HELPER FUNCTIONS
    
    func setMenu() -> SideMenuNavigationController{
       
        let menuVC = AppDelegate.sharedInstance.storyBoard.instantiateViewController(withIdentifier: SideMenuViewController.identifier)as! SideMenuViewController
        let menuLeftNavigationController = SideMenuNavigationController.init(rootViewController: menuVC)
        menuLeftNavigationController.settings = makeSetting()
        SideMenuManager.default.leftMenuNavigationController = menuLeftNavigationController
        return SideMenuManager.default.leftMenuNavigationController!
    }
    func makeSetting()-> SideMenuSettings{
        let presentationStyle = SideMenuPresentationStyle.menuSlideIn
        presentationStyle.menuStartAlpha = CGFloat(0.8)
        presentationStyle.presentingEndAlpha = 0.5
        var setting = SideMenuSettings()
        setting.presentationStyle = presentationStyle
        setting.menuWidth = 290
        return setting
        
    }
    
     func dateConvertor(inputFormat: String, outputFormat: String, dateString: String)-> String {
        let inputFormatter = DateFormatter()
        inputFormatter.dateFormat = inputFormat
        let outputFormatter = DateFormatter()
        outputFormatter.dateFormat = outputFormat
        let showDate = inputFormatter.date(from: dateString) ?? Date()
        let resultString = outputFormatter.string(from: showDate)
        return resultString
    }
    
    func timeConvertor(inputFormat: String, outputFormat: String, timeString: String)-> String {
       let inputFormatter = DateFormatter()
       inputFormatter.dateFormat = inputFormat
       let outputFormatter = DateFormatter()
       outputFormatter.dateFormat = outputFormat
       let showTime = inputFormatter.date(from: timeString) ?? Date()
       let resultString = outputFormatter.string(from: showTime)
       return resultString
   }
}
