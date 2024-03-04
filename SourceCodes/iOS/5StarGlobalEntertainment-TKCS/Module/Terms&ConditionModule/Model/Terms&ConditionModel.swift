//
//  Terms&ConditionModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import Foundation
// MARK: - Terms and Condition Model
struct TermsConditionModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message, data: String?
}
