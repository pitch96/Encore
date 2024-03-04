//
//  Extension+DateFormatter.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 08/12/22.
//

import Foundation

class DateFormate{
    
    func getdate(strFirstDate : String , strSecondDate : String )->String{
        let inputFormatter = DateFormatter()
        inputFormatter.dateFormat = "YYYY-MM-dd"
        let outputFormatter = DateFormatter()
        outputFormatter.dateFormat = "MMM dd"
        let showDate = inputFormatter.date(from: strFirstDate) ?? Date()
        let resultString = outputFormatter.string(from: showDate )
        debugPrint(resultString)
        
        let inputFormatter1 = DateFormatter()
        inputFormatter1.dateFormat = "YYYY-MM-dd"
        let outputFormatter1 = DateFormatter()
        outputFormatter1.dateFormat = "dd"
        let showDate1 = inputFormatter1.date(from: strSecondDate)
        let resultString1 = outputFormatter1.string(from: showDate1 ?? Date())
        debugPrint(resultString1)
        
        return resultString + " - " + resultString1
    }
    func changeDate(date: String){
        let inputFormatter = DateFormatter()
        inputFormatter.dateFormat = "YYYY-MM-dd"
        let outputFormatter = DateFormatter()
        outputFormatter.dateFormat = "dd/mm/yyyy"
        let showDate = inputFormatter.date(from: date) ?? Date()
        let resultString = outputFormatter.string(from: showDate )
        debugPrint(resultString)
    }
}
